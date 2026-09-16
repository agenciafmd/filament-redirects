<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Observers;

final class RedirectObserver
{
    public function saved(): void
    {
        cache()->forget('use-redirect-package');
    }
}
