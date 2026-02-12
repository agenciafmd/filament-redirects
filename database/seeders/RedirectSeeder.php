<?php

namespace Agenciafmd\Redirects\Database\Seeders;

use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Database\Seeder;

class RedirectSeeder extends Seeder
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
