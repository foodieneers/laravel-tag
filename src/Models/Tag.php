<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Models;

use Foodieneers\Tag\Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 * @property string|null $description
 *  */
#[Fillable([
    'name',
    'description',
    'category_id',
])]
final class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    public static function name(string $name): self
    {
        return self::query()->firstOrCreate(['name' => $name], ['description' => 'Automatically generated']);
    }

    /** @return BelongsTo<TagCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TagCategory::class, 'category_id');
    }

    /** @return BelongsToMany<Model, $this> */
    public function tagged(): BelongsToMany
    {
        $taggableModel = config('tag.taggable_model');
        assert(is_string($taggableModel) && is_a($taggableModel, Model::class, true));

        return $this->belongsToMany($taggableModel, 'tag_model', 'tag_id', 'model_id')->withPivot('created_at');
    }
}
