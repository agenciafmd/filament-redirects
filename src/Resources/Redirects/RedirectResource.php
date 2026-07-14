<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Resources\Redirects;

use Agenciafmd\Redirects\Models\Redirect;
use Agenciafmd\Redirects\Resources\Redirects\Pages\CreateRedirect;
use Agenciafmd\Redirects\Resources\Redirects\Pages\EditRedirect;
use Agenciafmd\Redirects\Resources\Redirects\Pages\ListRedirects;
use Agenciafmd\Redirects\Resources\Redirects\Schemas\RedirectForm;
use Agenciafmd\Redirects\Resources\Redirects\Tables\RedirectsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

final class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowRightOnRectangle;

    protected static ?string $recordTitleAttribute = 'from';

    public static function getModelLabel(): string
    {
        return __('Redirect');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Redirects');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-redirects.navigation_sort');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-redirects.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return RedirectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
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
