<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Resources\Redirects\Schemas;

use Agenciafmd\Admix\Resources\Infolists\Components\DateTimeEntry;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Group::make([
                            Section::make(__('General'))
                                ->schema([
                                    Select::make('type')
                                        ->translateLabel()
                                        ->options([
                                            '301' => __('Permanente (301)'),
                                            '302' => __('Temporário (302)'),
                                        ])
                                        ->required()
                                        ->default('301'),
                                    TextEntry::make('placeholder')
                                        ->hiddenLabel(),
                                    TextInput::make('from')
                                        ->translateLabel()
                                        ->prefix(config('app.url'))
                                        ->dehydrateStateUsing(function (?string $state): string {
                                            return '/' . mb_trim($state, '/');
                                        })
                                        ->required(),
                                    TextInput::make('to')
                                        ->translateLabel()
                                        ->url()
                                        ->required(),
                                ])
                                ->collapsible()
                                ->columns()
                                ->columnSpan(2),
                        ])
                            ->columnSpan(2),
                        Group::make([
                            Section::make(__('Information'))
                                ->schema([
                                    Toggle::make('is_active')
                                        ->translateLabel()
                                        ->default(true)
                                        ->columnSpan(2),
                                    DateTimeEntry::make('created_at'),
                                    DateTimeEntry::make('updated_at'),
                                ])
                                ->collapsible()
                                ->columns(),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
