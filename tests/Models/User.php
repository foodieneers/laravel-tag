<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Tests\Models;

use Foodieneers\Tag\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    use HasTags;

    protected $fillable = ['name', 'email', 'password'];
}
