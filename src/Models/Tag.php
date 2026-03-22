<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Models;

use Foodieneers\Tag\Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 * @property string|null $description
 *  */
final class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    /** @var class-string<Model> */
    private static string $taggableModel = Model::class;

    public static function name(string $name): self
    {
        return self::query()->firstOrCreate(['name' => $name], ['description' => 'Automatically generated']);
    }

    /** @param class-string<Model> $class */
    public static function setTaggableModel(string $class): void
    {
        self::$taggableModel = $class;
    }

    /** @return BelongsTo<TagCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TagCategory::class, 'category_id');
    }

    /** @return BelongsToMany<Model, $this> */
    public function tagged(): BelongsToMany
    {
        return $this->belongsToMany(self::$taggableModel, 'tag_model', 'tag_id', 'model_id')->withPivot('created_at');
    }
}
