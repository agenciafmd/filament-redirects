<?php

namespace Agenciafmd\Redirects\Observers;

use Agenciafmd\Redirects\Models\Redirect;

class RedirectObserver
{
    public function saved(Redirect $model): void
    {
        cache()->forget('use-redirect-package');
    }
}