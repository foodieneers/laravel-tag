<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Database\Factories;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

final class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
