<?php

declare(strict_types=1);

namespace Agenciafmd\Redirects\Database\Seeders;

use Agenciafmd\Redirects\Database\Factories\RedirectFactory;
use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Database\Seeder;

final class RedirectSeeder extends Seeder
{
    public function run(): void
    {
        Redirect::query()
            ->truncate();

        RedirectFactory::new()
            ->count(50)
            ->create();
    }
}
