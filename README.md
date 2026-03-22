# Laravel Tag

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foodieneers/laravel-tag.svg?style=flat-square)](https://packagist.org/packages/foodieneers/laravel-tag)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/foodieneers/laravel-tag/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/foodieneers/laravel-tag/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/foodieneers/laravel-tag/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/foodieneers/laravel-tag/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/foodieneers/laravel-tag.svg?style=flat-square)](https://packagist.org/packages/foodieneers/laravel-tag)

A Laravel package for tagging Eloquent models. Add the `HasTags` trait to any model and start tagging.

## Installation

```bash
composer require foodieneers/laravel-tag
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="laravel-tag-migrations"
php artisan migrate
```

Add the `HasTags` trait to your model (e.g. `User`):

```php
use Foodieneers\Tag\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasTags;
}
```

That's it. Your model can now be tagged.

---

## API Reference

### HasTags Trait

Add to any Eloquent model that should be taggable.

#### `tags()` — BelongsToMany relation

Returns the tags relation. Use for attach, detach, sync, or querying.

```php
$user->tags;                    // Collection of Tag models
$user->tags()->attach($tagId);  // Attach by ID
$user->tags()->detach($tagId);  // Detach by ID
$user->tags()->sync([1, 2, 3]); // Sync tag IDs
```

#### `tag(string $name): void`

Attaches a tag by name. Creates the tag if it doesn't exist.

```php
$user->tag('developer');
$user->tag('admin');
```

#### `detag(string $name): void`

Removes a tag by name. No-op if the tag doesn't exist or isn't attached.

```php
$user->detag('developer');
```

---

### Tag Model

#### `Tag::name(string $name): Tag`

Get or create a tag by name. Creates with `description => 'Automatically generated'` when new.

```php
$tag = Tag::name('laravel');
```

#### `Tag::setTaggableModel(string $class): void`

Sets which model class is taggable. Called automatically by `HasTags::bootHasTags()`. Only needed if you use multiple taggable models or customize behavior.

```php
Tag::setTaggableModel(User::class);
```

#### `$tag->tagged(): BelongsToMany`

Returns the relation to models that have this tag.

```php
$tag->tagged;           // Collection of tagged models (e.g. Users)
$tag->tagged()->get();  // Query builder
```

Pivot includes `created_at`.

#### `$tag->category(): BelongsTo`

Returns the optional tag category.

```php
$tag->category;  // TagCategory or null
```

---

### TagCategory Model

#### `TagCategory::name(string $name): TagCategory`

Get or create a category by name. Creates with `description => 'Automatically generated'` when new.

```php
$category = TagCategory::name('programming');
```

#### `$category->tags(): HasMany`

Returns tags in this category.

```php
$category->tags;  // Collection of Tag models
```

---

## Example

```php
// Tag a user
$user->tag('developer');
$user->tag('admin');

// List tags
$user->tags->pluck('name');  // ['developer', 'admin']

// Remove a tag
$user->detag('admin');

// Sync tags (replace all)
$user->tags()->sync([
    Tag::name('moderator')->id,
    Tag::name('reviewer')->id,
]);

// From a tag: get all tagged models
$tag = Tag::name('developer');
$tag->tagged;  // Users (or your taggable model) with this tag
```

---

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Azzarip](https://github.com/Azzarip)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
