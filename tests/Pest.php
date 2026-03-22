<?php

declare(strict_types=1);

use Foodieneers\Tag\Tests\Models\User;
use Foodieneers\Tag\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function createUser(): User
{
    return User::query()->create([
        'name' => 'Pivot User',
        'email' => 'pivot@example.com',
        'password' => bcrypt('password'),
    ]);
}
