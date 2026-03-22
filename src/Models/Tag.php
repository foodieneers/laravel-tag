<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Models;

use Foodieneers\Tag\Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property string $name @property string|null $description */
final class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public static function name(string $name): self
    {
        return self::query()->firstOrCreate(['name' => $name], ['description' => 'Automatically generated']);
    }

    /** @return BelongsTo<TagCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TagCategory::class, 'category_id');
    }
}
