<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Tests\Feature\Seeders;

use Agenciafmd\Redirects\Database\Seeders\RedirectSeeder;
use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\seed;

uses(TestCase::class, RefreshDatabase::class);

it('seeds the redirects from the factory', function (): void {
    seed(RedirectSeeder::class);

    expect(Redirect::query()->count())->toBe(50);
});
