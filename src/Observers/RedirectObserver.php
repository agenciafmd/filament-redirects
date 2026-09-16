<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Observers;

final class RedirectObserver
{
    public function saved(): void
    {
        $this->forgetCache();
    }

    public function deleted(): void
    {
        $this->forgetCache();
    }

    public function restored(): void
    {
        $this->forgetCache();
    }

    public function forceDeleted(): void
    {
        $this->forgetCache();
    }

    private function forgetCache(): void
    {
        cache()->forget('use-redirect-package');
    }
}
