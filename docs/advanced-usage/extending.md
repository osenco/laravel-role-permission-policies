# Extending

## Adding fields to your models
You can add your own migrations to make changes to the role/permission tables, as you would for adding/changing fields in any other tables in your Laravel project.

Following that, you can add any necessary logic for interacting with those fields into your custom/extended Models.

Here is an example of adding a 'description' field to your Permissions and Roles tables:

```sh
php artisan make:migration add_description_to_permissions_tables
```
And in the migration file:
```php
public function up()
{
    Schema::table('permissions', function (Blueprint $table) {
        $table->string('description')->nullable();
    });
    Schema::table('roles', function (Blueprint $table) {
        $table->string('description')->nullable();
    });
}
```

Semi-Related article: [Adding Extra Fields To Pivot Table](https://quickadminpanel.com/blog/laravel-belongstomany-add-extra-fields-to-pivot-table/) (video)

## Adding a description to roles and permissions
A common question is "how do I add a description for my roles or permissions?".

By default, a 'description' field is not included in this package, to keep the model memory usage low, because not every app has a need for displayed descriptions.

But you are free to add it yourself if you wish. You can use the example above.

### Multiple Language Descriptions

If you need your 'description' to support multiple languages, simply use Laravel's built-in language features. You might prefer to rename the 'description' field in these migration examples from 'description' to 'description_key' for clarity.


## Extending User Models
Laravel's authorization features are available in models which implement the `Illuminate\Foundation\Auth\Access\Authorizable` trait. 

By default Laravel does this in `\App\Models\User` by extending `Illuminate\Foundation\Auth\User`, in which the trait and `Illuminate\Contracts\Auth\Access\Authorizable` contract are declared.

If you are creating your own User models and wish Authorization features to be available, you need to implement `Illuminate\Contracts\Auth\Access\Authorizable` in one of those ways as well.

## Child User Models

Due to the nature of polymorphism and Eloquent's hard-coded mapping of model names in the database, setting relationships for child models that inherit permissions of the parent can be difficult (even near impossible depending on app requirements, especially when attempting to do inverse mappings). However, one thing you might consider if you need the child model to never have its own permissions/roles but to only use its parent's permissions/roles, is to [override the `getMorphClass` method on the model](https://github.com/laravel/framework/issues/17830#issuecomment-345619085).

eg: This could be useful, but only if you're willing to give up the child's independence for roles/permissions:
```php
    public function getMorphClass()
    {
        return 'users';
    }
```

## Extending Role and Permission Models
If you are extending or replacing the role/permission models, you will need to specify your new models in this package's `config/permission.php` file. 

First be sure that you've published the configuration file (see the Installation instructions), and edit it to update the `models.role` and `models.permission` values to point to your new models.

Note the following requirements when extending/replacing the models: 

### Extending
If you need to EXTEND the existing `Role` or `Permission` models note that:

- Your `Role` model needs to `extend` the `Osen\Permission\Models\Role` model
- Your `Permission` model needs to `extend` the `Osen\Permission\Models\Permission` model
- You need to update `config/permission.php` to specify your namespaced model

eg:
```php
<?php
namespace App\Models;
use Osen\Permission\Models\Role as OsenRole;

class Role extends OsenRole
{
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
}
```


### Replacing
In MOST cases you will only EXTEND the models as described above.
In the rare case that you have need to REPLACE the existing `Role` or `Permission` models you need to keep the following things in mind:

- If you are REPLACING and NOT EXTENDING the existing Model, do the following (and do NOT extend as described above):
- Your `Role` model needs to implement the `Osen\Permission\Contracts\Role` contract
- Your `Permission` model needs to implement the `Osen\Permission\Contracts\Permission` contract
- You need to update `config/permission.php` to specify your namespaced model

