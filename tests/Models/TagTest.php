<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;
use Foodieneers\Tag\Models\TagCategory;

test('name creates tag when none exists', function () {
    expect(Tag::query()->count())->toBe(0);

    $tag = Tag::name('php');

    expect($tag->name)->toBe('php')
        ->and($tag->description)->toBe('Automatically generated')
        ->and(Tag::query()->count())->toBe(1);
});

test('name returns existing tag when one exists', function () {
    $existing = Tag::factory()->create(['name' => 'laravel', 'description' => 'Original']);

    $tag = Tag::name('laravel');

    expect($tag->id)->toBe($existing->id)
        ->and($tag->description)->toBe('Original')
        ->and(Tag::query()->count())->toBe(1);
});

test('tag attributes', function () {
    $tag = Tag::factory()->create();

    $actual = $tag->toArray() |> array_keys(...);

    $expected = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    expect($actual)->toEqualCanonicalizing($expected);
});

test('tag has category', function () {
    $tag = Tag::factory()->create();
    $category = TagCategory::factory()->create();
    $tag->category()->associate($category);
    $tag->save();

    expect($tag->category)->toBeInstanceOf(TagCategory::class);
    expect($tag->category->id)->toBe($category->id);
});
