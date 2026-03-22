<?php

namespace Foodieneers\Tag\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
}
