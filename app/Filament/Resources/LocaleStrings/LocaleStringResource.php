<?php

namespace App\Filament\Resources\LocaleStrings;

use App\Filament\Resources\LocaleStrings\Pages\ManageLocaleStrings;
use App\Models\LocaleString;
use BackedEnum;
use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaravelLang\Locales\Facades\Locales;
use Livewire\Form;

class LocaleStringResource extends Resource
{
    protected static ?string $model = LocaleString::class;

    public static function getModelLabel(): string
    {
        return __('Locale String');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Locale Strings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Locale Strings');
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::AtSymbol;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(function (Get $get): array {
                $schema = [
                    TextInput::make('title')->translateLabel(),
                    TextInput::make('description')->translateLabel(),
                    TextInput::make('key')->translateLabel()
                        ->required(),
                    TextInput::make('default')->translateLabel(),
                ];

                $schema[] = Section::make(__('Values'))
                    ->columnSpanFull()
                    ->statePath('locale_values')
                    ->description(__('Separate locale values'))
                    ->schema(function () {
                        $availableCodes = array_column(Locales::installed()->toArray(), 'code');
                        $schemaLocales = [];
                        foreach ($availableCodes as $index => $locale) {
                            $schemaLocales[] = TextInput::make($locale)->translateLabel()->columnSpanFull();
                        }
                        return $schemaLocales;
                    })->collapsible();

                return $schema;
            });
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')->translateLabel()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('description')->translateLabel()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('key')->translateLabel(),
                TextEntry::make('default')->translateLabel()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('created_at')->translateLabel()
                    ->dateTime()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('updated_at')->translateLabel()
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')->translateLabel()
                    ->dateTime()
                    ->visible(fn(LocaleString $record): bool => $record->trashed())->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->withTrashed())
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->translateLabel()
                    ->searchable(),
                /*TextColumn::make('description')->translateLabel()
                    ->searchable(),*/
                TextColumn::make('key')->translateLabel()
                    ->searchable()->badge()
                    ->color('success')->copyable(),
                TextColumn::make('default')->translateLabel()
                    ->searchable()->copyable()->limit(50)->wrap(),
                TextColumn::make('created_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(100)
            ->filters([
                TrashedFilter::make()->default(1),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
                ForceDeleteAction::make()->iconButton(),
                RestoreAction::make()->iconButton()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLocaleStrings::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
