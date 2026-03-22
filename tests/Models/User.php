<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Tests\Models;

use Foodieneers\Tag\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;
use Override;

final class User extends Model
{
    use HasTags;

    #[Override]
    protected $fillable = ['name', 'email', 'password'];
}
