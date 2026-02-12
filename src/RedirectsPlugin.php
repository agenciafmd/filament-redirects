<?php

namespace Agenciafmd\Redirects;

use Agenciafmd\Redirects\Resources\Redirects\RedirectResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

final class RedirectsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'redirects';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                RedirectResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
