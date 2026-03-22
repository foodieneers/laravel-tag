<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Traits;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTags
{
    public static function bootHasTags(): void
    {
        Tag::setTaggableModel(static::class);
    }

    public function tag(string $name): void
    {
        $tag = Tag::name($name);
        if (! $this->tags()->where('tag_id', $tag->id)->exists()) {
            $this->tags()->attach($tag->id, ['created_at' => now()]);
            $this->unsetRelation('tags');
        }
    }

    public function detag(string $name): void
    {
        $tag = Tag::query()->where('name', $name)->first();
        if ($tag !== null) {
            $this->tags()->detach($tag->id);
            $this->unsetRelation('tags');
        }
    }

    /** @return BelongsToMany<Tag, $this> */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'tag_model',
            'model_id',
            'tag_id'
        )->withPivot('created_at');
    }
}
