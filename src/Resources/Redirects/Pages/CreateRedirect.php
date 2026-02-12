<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Resources\Redirects\Pages;

use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
use Agenciafmd\Redirects\Resources\Redirects\RedirectResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateRedirect extends CreateRecord
{
    use RedirectBack;

    protected static string $resource = RedirectResource::class;
}
