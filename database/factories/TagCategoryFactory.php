<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Database\Factories;

use Foodieneers\Tag\Models\TagCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/** @extends Factory<TagCategory> */
final class TagCategoryFactory extends Factory
{
    #[Override]
    protected $model = TagCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
