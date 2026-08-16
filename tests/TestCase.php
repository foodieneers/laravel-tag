<?php

namespace Foodieneers\Tag\Tests;

use Foodieneers\Tag\Tests\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Foodieneers\Tag\TagServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('tag.taggable_model', User::class);

        Factory::guessFactoryNamesUsing(
            fn (string $modelName): string => 'Foodieneers\\Tag\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            TagServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

         foreach (File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
    }
}
