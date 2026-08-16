<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Database\Factories;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/** @extends Factory<Tag> */
final class TagFactory extends Factory
{
    #[Override]
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
