<?php

namespace Agenciafmd\Redirects\Http\Middleware;

use Agenciafmd\Redirects\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class UseRedirectPackage
{
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->url();

        $redirects = cache()->rememberForever('use-redirect-package', static function () {
            return collect(Redirect::query()
                ->isActive()
                ->select([
                    'from',
                    'to',
                    'type',
                ])
                ->get()
                ->map(static function ($item) {
                    $item['from'] = config('app.url') . '/' . str($item->from)
                            ->trim('/')
                            ->trim()
                            ->__toString();

                    return $item;
                })
                ->toArray());
        });

        $redirect = $redirects->where('from', $uri)
            ->first();
        if ($redirect) {
            return redirect()->to($redirect['to'], $redirect['type']);
        }

        $wildCardRedirect = $redirects->map(function ($redirect) {
            $redirect['from'] = str($redirect['from'])
                ->replace(config('app.url'), '')
                ->trim('/')
                ->trim()
                ->__toString();

            return $redirect;
        })
            ->filter(static function ($redirect) {
                return str($redirect['from'])
                    ->endsWith('*');
            })
            ->filter(function ($redirect) use ($request) {
                return $request->is($redirect['from']);
            })
            ->first();
        if ($wildCardRedirect) {
            return redirect()->to($wildCardRedirect['to'], $wildCardRedirect['type']);
        }

        return $next($request);
    }
}