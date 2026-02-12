<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Database\Seeders;

use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Database\Seeder;

final class RedirectSeeder extends Seeder
{
    public function run(): void
    {
        Redirect::query()
            ->truncate();

        Redirect::factory()
            ->count(50)
            ->create();
    }
}
