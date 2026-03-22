<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;
use Foodieneers\Tag\Models\TagCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('name creates tag category when none exists', function () {
    expect(TagCategory::query()->count())->toBe(0);

    $tagCategory = TagCategory::name('technology');

    expect($tagCategory->name)->toBe('technology')
        ->and($tagCategory->description)->toBe('Automatically generated')
        ->and(TagCategory::query()->count())->toBe(1);
});

test('name returns existing tag category when one exists', function () {
    $existing = TagCategory::factory()->create(['name' => 'programming', 'description' => 'Original']);

    $tagCategory = TagCategory::name('programming');

    expect($tagCategory->id)->toBe($existing->id)
        ->and($tagCategory->description)->toBe('Original')
        ->and(TagCategory::query()->count())->toBe(1);
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

test('tag category has tags', function () {
    $tagCategory = TagCategory::factory()->create();
    $tag = Tag::factory()->create(['category_id' => $tagCategory->id]);

    expect($tagCategory->tags)->toHaveCount(1);
    expect($tagCategory->tags())->toBeInstanceOf(HasMany::class);
    expect($tagCategory->tags()->count())->toBe(1);
    expect($tagCategory->tags()->first()->id)->toBe($tag->id);
});
