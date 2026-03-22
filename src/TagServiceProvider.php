<?php

namespace Foodieneers\Tag;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Foodieneers\Tag\Commands\TagCommand;

class TagServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-tag')
            ->hasMigration('create_laravel_tag_table');
    }
}
