<?php

declare(strict_types=1);

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

test('user can have tags', function () {
    $user = createUser();

    $tag1 = Tag::factory()->create(['name' => 'developer']);
    $tag2 = Tag::factory()->create(['name' => 'admin']);

    $user->tags()->attach([$tag1->id, $tag2->id]);

    expect($user->tags)->toHaveCount(2)
        ->and($user->tags->pluck('name')->toArray())->toEqualCanonicalizing(['developer', 'admin']);

    expect($user->tags())->toBeInstanceOf(BelongsToMany::class);
});

test('user can attach and detach tags', function () {
    $user = createUser();
    $tag = Tag::factory()->create(['name' => 'moderator']);

    $user->tags()->attach($tag->id);
    expect($user->fresh()->tags)->toHaveCount(1);

    $user->tags()->detach($tag->id);
    expect($user->fresh()->tags)->toHaveCount(0);
});

test('user can sync tags', function () {
    $user = createUser();

    $tag1 = Tag::factory()->create(['name' => 'tag-a']);
    $tag2 = Tag::factory()->create(['name' => 'tag-b']);
    $tag3 = Tag::factory()->create(['name' => 'tag-c']);

    $user->tags()->sync([$tag1->id, $tag2->id]);
    expect($user->fresh()->tags)->toHaveCount(2);

    $user->tags()->sync([$tag2->id, $tag3->id]);
    expect($user->fresh()->tags->pluck('name')->toArray())->toEqualCanonicalizing(['tag-b', 'tag-c']);
});

test('pivot includes created_at', function () {
    $user = createUser();

    $tag = Tag::factory()->create(['name' => 'pivot-test']);
    $user->tags()->attach($tag->id);

    $pivot = $user->tags->first()->pivot;

    expect($pivot->tag_id)->toBe($tag->id)
        ->and($pivot->model_id)->toBe($user->id)
        ->and($pivot->created_at)->not->toBeNull();
});

test('tag attaches tag by name', function () {
    $user = createUser();

    $user->tag('Test Tag');

    expect($user->tags)->toHaveCount(1);
    expect($user->tags->first()->name)->toBe('Test Tag');
    $pivot = $user->tags->first()->pivot;
    expect($pivot->created_at)
        ->not->toBeNull()
        ->and($pivot->created_at->diffInSeconds(now()))->toBeLessThan(5);

});

test('detag removes tag by name', function () {
    $user = createUser();

    $user->tag('Test Tag');

    expect($user->tags)->toHaveCount(1);
    $user->detag('Test Tag');
    $user->refresh();
    expect($user->tags)->toHaveCount(0);
});
