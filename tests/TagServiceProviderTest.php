<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

it('publishes the tags tables migration', function () {
    Artisan::call('vendor:publish', [
        '--tag' => 'tag-migrations',
        '--force' => true,
    ]);

    $migrationFiles = File::glob(database_path('migrations/*create_tags_tables*.php'));

    expect($migrationFiles)->not->toBeEmpty();

    $contents = File::get($migrationFiles[0]);

    expect($contents)
        ->toContain("Schema::create('tag_categories'")
        ->toContain("Schema::create('tags'")
        ->toContain("Schema::create('tag_model'");
});
