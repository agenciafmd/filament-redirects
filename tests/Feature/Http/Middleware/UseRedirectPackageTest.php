<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Tests\Feature\Http\Middleware;

use Agenciafmd\Redirects\Http\Middleware\UseRedirectPackage;
use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

function handleRedirect(string $uri): Response
{
    return new UseRedirectPackage()->handle(Request::create($uri), static fn (): Response => response('next'));
}

it('redirects an exact path with its status code', function (): void {
    Redirect::factory()->create(['is_active' => true, 'from' => '/antiga/', 'to' => 'https://fmd.ag/nova', 'type' => '301']);

    $response = handleRedirect('/antiga');

    expect($response->getStatusCode())->toBe(301)
        ->and($response->headers->get('Location'))->toBe('https://fmd.ag/nova');
});

it('redirects every path under a wildcard', function (): void {
    Redirect::factory()->create(['is_active' => true, 'from' => 'blog/*', 'to' => 'https://fmd.ag/artigos', 'type' => '302']);

    $response = handleRedirect('/blog/categoria/artigo');

    expect($response->getStatusCode())->toBe(302)
        ->and($response->headers->get('Location'))->toBe('https://fmd.ag/artigos');
});

it('passes the request on when the redirect is inactive', function (): void {
    Redirect::factory()->create(['is_active' => false, 'from' => '/inativa', 'to' => 'https://fmd.ag/x', 'type' => '301']);

    expect(handleRedirect('/inativa')->getContent())->toBe('next');
});
