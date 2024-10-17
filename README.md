<p>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
<img alt="Packagist Stars" src="https://img.shields.io/packagist/stars/arafat69/laravel-repository">
</a>
<a href="https://packagist.org/packages/arafat69/laravel-repository">
    <img alt="GitHub issues" src="https://img.shields.io/github/issues/arafat69/laravel-repository">
</a>
<a href="https://packagist.org/packages/arafat-dev/laravel-repository"><img src="https://img.shields.io/packagist/dt/arafat69/laravel-repository" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/arafat-dev/laravel-repository"><img src="https://img.shields.io/packagist/v/arafat69/laravel-repository" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/arafat-dev/laravel-repository"><img src="https://img.shields.io/packagist/l/arafat69/laravel-repository" alt="License"></a>
</p>

# laravel-repository
Simple but powerfull laravel repository pattern

---

## Installation

```sh
composer require arafat69/laravel-repository
```

After installing the package you will see a file **repository.php** is created inside **repositories** folder

##Make a repository

```php
php artisan make:repository UserRepository
or
// use scope for specific model
php artisan make:repository UserRepository --model=User
```

## How to create function in repository

```php
//Create
public static function storeByRequest($request): User
{
    return self::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        // ...
    ]);
}

// Update
public static function updateByRequest($request, User $user): User
{
    self::update($user, [
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        // ...
    ]);

    // or

    $user->update([
        // your update data
    ])

    return $user;
}
// etc...
```
## Use from controller

#### Import first the Repository

```php
//example UserRepository
use App\Repositories\UserRepository;
```
```php
// get all user
UserRepository::getAll(); //retun all users
// filter user use query
UserRepository::query()->whereName('jon')->get();
// store method call 
UserRepository::storeByRequest($request);
// update method call 
UserRepository::updateByRequest($request, $user);
//find
UserRepository::find($userID);
//get first recode
UserRepository::first();
// delete recode
UserRepository::delete($userID);
```
#### Publish stubs folder
```sh
php artisan vendor:publish --tag=stubs
```
## Contribution
You're open to create any Pull request.
