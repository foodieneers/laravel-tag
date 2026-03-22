<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\TagCategory;

test('name creates tag category when none exists', function () {
    expect(TagCategory::count())->toBe(0);

    $tagCategory = TagCategory::name('technology');

    expect($tagCategory->name)->toBe('technology')
        ->and($tagCategory->description)->toBe('Automatically generated')
        ->and(TagCategory::count())->toBe(1);
});

test('name returns existing tag category when one exists', function () {
    $existing = TagCategory::factory()->create(['name' => 'programming', 'description' => 'Original']);

    $tagCategory = TagCategory::name('programming');

    expect($tagCategory->id)->toBe($existing->id)
        ->and($tagCategory->description)->toBe('Original')
        ->and(TagCategory::count())->toBe(1);
});

test('tag category attributes', function () {
    $tagCategory = TagCategory::factory()->create();

    $actual = $tagCategory->toArray() |> array_keys(...);

    $expected = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    expect($actual)->toEqualCanonicalizing($expected);
});
