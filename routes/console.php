<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:vue {name}', function ($name) {
    $path = resource_path("js/Components/{$name}.vue");
    if (File::exists($path)) return $this->error("Component already exists!");
    
    File::ensureDirectoryExists(resource_path("js/Components"));
    File::put($path, "<template>\n\n</template>\n<script setup>\n\n</script>");
    $this->info("Vue component created at {$path}");
});
