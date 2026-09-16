<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Http\Middleware;

use Agenciafmd\Redirects\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class UseRedirectPackage
{
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->url();

        $redirects = cache()->rememberForever('use-redirect-package', static fn (): Collection => collect(Redirect::query()
            ->isActive()
            ->select([
                'from',
                'to',
                'type',
            ])
            ->get()
            ->map(static function (array $item): array {
                $item['from'] = config('app.url') . '/' . str($item->from)
                    ->trim('/')
                    ->trim()
                    ->__toString();

                return $item;
            })
            ->toArray()));

        $redirect = $redirects->where('from', $uri)
            ->first();
        if ($redirect) {
            return redirect()->to($redirect['to'], $redirect['type']);
        }

        $wildCardRedirect = $redirects->map(function (array $redirect): array {
            $redirect['from'] = str($redirect['from'])
                ->replace(config('app.url'), '')
                ->trim('/')
                ->trim()
                ->__toString();

            return $redirect;
        })
            ->filter(static fn (array $redirect) => str($redirect['from'])
                ->endsWith('*'))
            ->filter(fn (array $redirect) => $request->is($redirect['from']))
            ->first();
        if ($wildCardRedirect) {
            return redirect()->to($wildCardRedirect['to'], $wildCardRedirect['type']);
        }

        return $next($request);
    }
}
