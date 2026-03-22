<?php

namespace Foodieneers\Tag\Database\Factories;

use Foodieneers\Tag\Models\TagCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagCategoryFactory extends Factory
{
    protected $model = TagCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
