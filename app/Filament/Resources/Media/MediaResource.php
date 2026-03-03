<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\ManageMedia;
use App\Models\Media;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    public static function getModelLabel(): string
    {
        return __('Media');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Media');
    }

    public static function getNavigationLabel(): string
    {
        return __('Media');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::SquaresPlus;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->translateLabel(),
                TextInput::make('description')->translateLabel(),
                TextInput::make('key')->translateLabel()
                    ->required(),
                TextInput::make('alt')->translateLabel(),
                Toggle::make('pointer_events')->translateLabel(),
                Toggle::make('autoplay')->translateLabel(),
                FileUpload::make('locale_values->ru')->translateLabel(),
                FileUpload::make('locale_values->en')->translateLabel(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')->translateLabel()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('key')->translateLabel(),
                TextEntry::make('alt')->translateLabel()
                    ->placeholder('-'),
                IconEntry::make('pointer_events')->translateLabel()
                    ->boolean()
                    ->placeholder('-'),
                IconEntry::make('autoplay')->translateLabel()
                    ->boolean()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')->translateLabel(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Media $record): bool => $record->trashed())->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->translateLabel()
                    ->searchable(),
                ImageColumn::make(name: 'locale_values->ru')->translateLabel()
                    ->square()
                    ->height(40),
                //TextColumn::make('description')->translateLabel()
                //    ->searchable(),
                TextColumn::make('key')->translateLabel()
                    ->searchable(),
                TextColumn::make('alt')->translateLabel()
                    ->searchable(),
                IconColumn::make('pointer_events')->translateLabel()
                    ->boolean(),
                IconColumn::make('autoplay')->translateLabel()
                    ->boolean(),
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
                TrashedFilter::make(),
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
            'index' => ManageMedia::route('/'),
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
