<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Http\Middleware;

use Agenciafmd\Redirects\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UseRedirectPackage
{
    public function handle(Request $request, Closure $next): Response
    {
        $redirects = collect($this->redirects());
        $path = mb_trim($request->path(), '/');

        $redirect = $redirects->firstWhere('from', $path)
            ?? $redirects->first(fn (array $redirect): bool => str_ends_with($redirect['from'], '*') && $request->is($redirect['from']));

        if ($redirect !== null) {
            return redirect()->to($redirect['to'], $redirect['type']);
        }

        return $next($request);
    }

    /**
     * @return array<int, array{from: string, to: string, type: int}>
     */
    private function redirects(): array
    {
        return cache()->rememberForever('use-redirect-package', static fn (): array => Redirect::query()
            ->isActive()
            ->select([
                'from',
                'to',
                'type',
            ])
            ->get()
            ->map(static fn (Redirect $redirect): array => [
                'from' => mb_trim(mb_trim($redirect->from), '/'),
                'to' => $redirect->to,
                'type' => (int) $redirect->type,
            ])
            ->all());
    }
}
