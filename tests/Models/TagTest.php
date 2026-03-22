<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;
use Foodieneers\Tag\Models\TagCategory;
use Foodieneers\Tag\Tests\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

test('tagged returns BelongsToMany relation', function () {
    Tag::setTaggableModel(User::class);
    $tag = Tag::factory()->create();

    expect($tag->tagged())->toBeInstanceOf(BelongsToMany::class);
});

test('tagged returns models attached to tag', function () {
    Tag::setTaggableModel(User::class);
    $user = createUser();
    $tag = Tag::factory()->create(['name' => 'attached-tag']);
    $user->tags()->attach($tag->id, ['created_at' => now()]);

    expect($tag->tagged)->toHaveCount(1)
        ->and($tag->tagged->first())->toBeInstanceOf(User::class)
        ->and($tag->tagged->first()->id)->toBe($user->id);
});

test('tagged pivot includes created_at', function () {
    Tag::setTaggableModel(User::class);
    $user = createUser();
    $tag = Tag::factory()->create(['name' => 'pivot-tag']);
    $user->tags()->attach($tag->id, ['created_at' => now()]);

    $pivot = $tag->tagged->first()->pivot;

    expect($pivot->tag_id)->toBe($tag->id)
        ->and($pivot->model_id)->toBe($user->id)
        ->and($pivot->created_at)->not->toBeNull();
});

test('setTaggableModel configures which model tagged returns', function () {
    Tag::setTaggableModel(User::class);
    $user = createUser();
    $tag = Tag::factory()->create(['name' => 'config-tag']);
    $user->tags()->attach($tag->id, ['created_at' => now()]);

    expect($tag->tagged->first())->toBeInstanceOf(User::class);
});
