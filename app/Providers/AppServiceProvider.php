<?php

namespace App\Providers;

use App\Models\LocaleString;
use App\Models\Media;
use App\Policies\LocaleStringPolicy;
use App\Policies\MediaPolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Media::class => MediaPolicy::class,
        LocaleString::class => LocaleStringPolicy::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        View::composer('*', function ($view) {
            $translations = LocaleString::pluck( 'locale_values', 'key');
            $defaults = LocaleString::pluck('default', 'key');
            $view->with('translations', $translations)->with('defaults', $defaults);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Gate::policy(LocaleString::class, LocaleStringPolicy::class);
        Gate::policy(Media::class, MediaPolicy::class);

        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null
        );
    }
}
