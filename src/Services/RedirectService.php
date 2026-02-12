<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Services;

use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Database\Eloquent\Builder;

final class RedirectService
{
    public static function make(): static
    {
        return app(self::class);
    }

    private function queryBuilder(): Builder
    {
        return Redirect::query();
    }
}
