<?php

namespace Foodieneers\Tag\Models;

use Foodieneers\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TagCategory extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public static function name(string $name): self
    {
        return self::firstOrCreate(
            ['name' => $name],
            ['description' => 'Automatically generated']
        );
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
