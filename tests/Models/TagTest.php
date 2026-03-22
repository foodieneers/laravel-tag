<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;

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
