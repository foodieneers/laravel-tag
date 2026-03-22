<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TagCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public static function name(string $name): self
    {
        return self::query()->firstOrCreate(['name' => $name], ['description' => 'Automatically generated']);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'category_id');
    }
}
