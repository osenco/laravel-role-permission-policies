# Basic Usage

## Add The Trait
First, add the `Osen\Permission\Traits\HasRoles` trait to your `User` model(s):

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Osen\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ...
}
```

## Create A Permission
This package allows for users to be associated with permissions and roles. Every role is associated with multiple permissions.
A `Role` and a `Permission` are regular Eloquent models. They require a `name` and can be created like this:

```php
use Osen\Permission\Models\Role;
use Osen\Permission\Models\Permission;

$role = Role::create(['name' => 'writer']);
$permission = Permission::create(['name' => 'edit articles']);
```

## Assign A Permission To A Role
A permission can be assigned to a role using either of these methods:

```php
$role->givePermissionTo($permission);
$permission->assignRole($role);
```

## Sync Permissions To A Role
Multiple permissions can be synced to a role using either of these methods:

```php
$role->syncPermissions($permissions);
$permission->syncRoles($roles);
```

## Remove Permission From A Role
A permission can be removed from a role using either of these methods:

```php
$role->revokePermissionTo($permission);
$permission->removeRole($role);
```

## Guard Name
If you're using multiple guards then the `guard_name` attribute must be set as well. Read about it in the [using multiple guards](./multiple-guards) documentation.

## Get Permissions For A User
The `HasRoles` trait adds Eloquent relationships to your models, which can be accessed directly or used as a base query:

```php
// get a list of all permissions directly assigned to the user
$permissionNames = $user->getPermissionNames(); // collection of name strings
$permissions = $user->permissions; // collection of permission objects

// get all permissions for the user, either directly, or from roles, or from both
$permissions = $user->getDirectPermissions();
$permissions = $user->getPermissionsViaRoles();
$permissions = $user->getAllPermissions();

// get the names of the user's roles
$roles = $user->getRoleNames(); // Returns a collection
```

## Scopes
The `HasRoles` trait also adds `role` and `withoutRole` scopes to your models to scope the query to certain roles or permissions:

```php
$users = User::role('writer')->get(); // Returns only users with the role 'writer'
$nonEditors = User::withoutRole('editor')->get(); // Returns only users without the role 'editor'
```

The `role` and `withoutRole` scopes can accept a string, a `\Osen\Permission\Models\Role` object or an `\Illuminate\Support\Collection` object.

The same trait also adds scopes to only get users that have or don't have a certain permission.

```php
$users = User::permission('edit articles')->get(); // Returns only users with the permission 'edit articles' (inherited or directly)
$usersWhoCannotEditArticles = User::withoutPermission('edit articles')->get(); // Returns all users without the permission 'edit articles' (inherited or directly)
```

The scope can accept a string, a `\Osen\Permission\Models\Permission` object or an `\Illuminate\Support\Collection` object.


## Eloquent Calls
Since Role and Permission models are extended from Eloquent models, basic Eloquent calls can be used as well:

```php
$allUsersWithAllTheirRoles = User::with('roles')->get();
$allUsersWithAllTheirDirectPermissions = User::with('permissions')->get();
$allRolesInDatabase = Role::all()->pluck('name');
$usersWithoutAnyRoles = User::doesntHave('roles')->get();
$allRolesExceptAandB = Role::whereNotIn('name', ['role A', 'role B'])->get();
```

## Counting Users Having A Role
One way to count all users who have a certain role is by filtering the collection of all Users with their Roles:
```php
$managersCount = User::with('roles')->get()->filter(
    fn ($user) => $user->roles->where('name', 'Manager')->toArray()
)->count();
```
