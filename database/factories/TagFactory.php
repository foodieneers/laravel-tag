<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Database\Factories;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Tag> */
final class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
