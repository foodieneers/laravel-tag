<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Traits;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTags
{
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
