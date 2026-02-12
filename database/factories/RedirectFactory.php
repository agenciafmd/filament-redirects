<?php

namespace Agenciafmd\Redirects\Database\Factories;

use Agenciafmd\Redirects\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
    protected $model = Redirect::class;

    public function definition(): array
    {
        return [
            'is_active' => fake()->boolean(),
            'from' => '/' . fake()->slug(),
            'to' => fake()->url(),
            'type' => fake()->randomElement(['301', '302']),
        ];
    }
}
