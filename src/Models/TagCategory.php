<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Models;

use Foodieneers\Tag\Database\Factories\TagCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property string $name @property string|null $description */
final class TagCategory extends Model
{
    /** @use HasFactory<TagCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public static function name(string $name): self
    {
        return self::query()->firstOrCreate(['name' => $name], ['description' => 'Automatically generated']);
    }

    /** @return HasMany<Tag, $this> */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'category_id');
    }
}
