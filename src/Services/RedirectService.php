<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Services;

final class RedirectService
{
    public static function make(): static
    {
        return resolve(self::class);
    }
}
