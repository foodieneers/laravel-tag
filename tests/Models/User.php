<?php

declare(strict_types=1);

namespace Foodieneers\Tag\Tests\Models;

use Foodieneers\Tag\Traits\HasTags;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'password'])]
final class User extends Model
{
    use HasTags;
}
