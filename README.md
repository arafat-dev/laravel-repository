<p>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
    <img alt="Packagist Stars" src="https://img.shields.io/packagist/stars/arafat69/laravel-repository">
</a>
<a href="https://github.com/arafat69/laravel-repository/issues">
    <img alt="GitHub issues" src="https://img.shields.io/github/issues/arafat69/laravel-repository">
</a>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
    <img src="https://img.shields.io/packagist/dt/arafat69/laravel-repository" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
    <img src="https://img.shields.io/packagist/v/arafat69/laravel-repository" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
    <img src="https://img.shields.io/packagist/l/arafat69/laravel-repository" alt="License">
</a>
</p>

# Laravel Repository

A simple, lightweight, and powerful Laravel repository pattern package with built-in **Artisan commands** for generating repositories quickly.
Supports **Laravel 7 and above**.

---

## Features

- Generate repositories using Artisan commands
- Supports **model-specific repositories**
- Clean, maintainable code following **repository pattern**
- Easy CRUD operations in repositories
- Supports all Laravel versions from **7+**
- Optional stubs publishing for customization

---

## Installation

```bash
composer require arafat69/laravel-repository
```

After installing, a repository.php file will be created in your Repositories folder.

---

## Generating a Repository

```bash
php artisan make:repository UserRepository
```

With a model:
// use scope for specific model

```bash
php artisan make:repository UserRepository --model=User
```

---

## Defining Functions in Repository

```php

// Create a new record
public static function storeByRequest($request): User
{
    return self::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        //...
    ]);
}

// Update existing record
public static function updateByRequest($request, User $user): User
{
    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        //...
    ]);

    return $user;
}

```

---

## Repository Function Examples

```php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Arafat\LaravelRepository\Repository;

class UserRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
    */
    public static function model()
    {
        return User::class;
    }

    /**
     * Create a new record from request
     */
    public static function storeByRequest(Request $request): User
    {
        return self::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            // add other fields here
        ]);
    }

    /**
     * Update an existing record
     */
    public static function updateByRequest(Request $request, User $user): User
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            // add other fields here
        ]);

        return $user;
    }

    /**
     * Update the logged-in user's profile
     */
    public static function profileUpdate(Request $request): User
    {
        $user = auth()->user();
        $user->update($request->only(['first_name', 'last_name', 'email', 'phone']));
        return $user;
    }

    /**
     * Get order summary for a user
     */
    public static function orderSummary(User $user)
    {
        return $user->orders()
                    ->selectRaw('count(*) as total_orders, sum(total) as total_amount')
                    ->first();
    }

    /**
     * Get all active users
     */
    public static function getActiveUsers()
    {
        return self::query()->where('status', true)->get();
    }

    /**
     * Delete a user
     */
    public static function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}

```

---

## Using Repository in Controller

```php

use App\Repositories\UserRepository;


// --- Custom repository methods ---

// Store user
UserRepository::storeByRequest($request);

// Update a user
$user = UserRepository::updateByRequest($request, $user);

// Update current logged-in user's profile
$currentUser = UserRepository::profileUpdate($request);

// Get order summary
$orderSummary = UserRepository::orderSummary($user);

// Get all active users
$activeUsers = UserRepository::getActiveUsers();

// Delete a user
UserRepository::deleteUser($user);

// --- Built-in repository methods (from the base repository) ---

// Get all users
$users = UserRepository::getAll();

// Query users with conditions
$users = UserRepository::query()->where('name','Jon')->get();

// Find a specific user by ID
$user = UserRepository::find($userID);

// Get the first record
$user = UserRepository::first();

// Delete a user by ID
UserRepository::delete($userID);

```

---

### Publishing Stubs

```bash
php artisan vendor:publish --tag=stubs
```

---

## Contribution

Feel free to open Pull Requests or submit issues.
Contributions are welcome!

---

## License

MIT

---

## Changelog v2.1.0

- This package is Abandone.
- Suggest: arafatdev/laravel-repository.
