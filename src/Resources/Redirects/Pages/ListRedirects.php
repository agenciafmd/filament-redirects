<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Resources\Redirects\Pages;

use Agenciafmd\Redirects\Resources\Redirects\RedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListRedirects extends ListRecords
{
    #[Override]
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
