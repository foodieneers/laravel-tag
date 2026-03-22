<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;

test('name creates tag when none exists', function () {
    expect(Tag::count())->toBe(0);

    $tag = Tag::name('php');

    expect($tag->name)->toBe('php')
        ->and($tag->description)->toBe('Automatically generated')
        ->and(Tag::count())->toBe(1);
});

test('name returns existing tag when one exists', function () {
    $existing = Tag::factory()->create(['name' => 'laravel', 'description' => 'Original']);

    $tag = Tag::name('laravel');

    expect($tag->id)->toBe($existing->id)
        ->and($tag->description)->toBe('Original')
        ->and(Tag::count())->toBe(1);
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
