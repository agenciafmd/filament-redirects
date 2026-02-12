<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Observers;

use Agenciafmd\Redirects\Models\Redirect;

final class RedirectObserver
{
    public function saved(Redirect $model): void
    {
        cache()->forget('use-redirect-package');
    }
}
