<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Tests\Feature\Observers;

use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('clears the redirects cache when a redirect changes', function (string $change): void {
    $redirect = Redirect::factory()->create();
    cache()->forever('use-redirect-package', ['cached']);

    match ($change) {
        'saved' => $redirect->update(['to' => 'https://fmd.ag/outra']),
        'deleted' => $redirect->delete(),
        'force deleted' => $redirect->forceDelete(),
    };

    expect(cache()->has('use-redirect-package'))->toBeFalse();
})->with(['saved', 'deleted', 'force deleted']);
