Laravel 4+ Searchy - Searching Made Easy
========================================

Searchy is an easy-to-use Laravel 4+ package that makes running user driven searches on data in your models easy and effective.
It requires no other software installed on your server (so a bit slower) but can be setup and ready to go in minutes.

Installation
----------------------------------------
Add the service provider to the `providers` array in Laravel's app/config/app.php file:
```
'TomLingham\Searchy\SearchyServiceProvider'
```

Add the Alias to the `aliases` array in Laravel's app/config/app.php file:
```
'Searchy' => 'TomLingham\Searchy\SearchBuilder'
```


Usage
----------------------------------------
To use Searchy, you can take advantage of magic methods.

If you are searching the name column/field of users in a `users` table you would, for example run:
```
$users = Searchy::users('name')->query('John Smith');
```
you can also write this as:

```
$users = Searchy::search('users')->query('John Smith');
```
These example both return a Laravel DB Query Builder Object, so you will need to chain `get()` to actually return the results in a usable object:

```
$users = Searchy::search('users')->query('John Smith')->get();
```


Configuration
----------------------------------------
You can publish the configuration file to override the settings by running `php artisan config:publish tom-lingham/searchy`

You can set the default driver to use for ssearches in the configuration file. Your options (At this stage) are: `fuzzy`, `simple` and `levenshtein`.

You can also override these methods using the following syntax when running a search:

```
Searchy::driver('fuzzy')->users('name')->query('Bat Man')->get();
```


Drivers
----------------------------------------
Searchy takes advantage of 'Drivers' to handle matching various conditions of the fields you specify.

Drivers are simply a specified group of 'Matchers' which match strings based on different conditions.

Currently there are only three drivers: Simple, Fuzzy and Levenshtein (Experimental).



### Road Map

So, the intention is to (in the future):

1. Remove Searchy's dependancy on Laravel
2. Include more drivers for more advanced searching (Including file searching, indexing and more)
3. Implement an AJAX friendly interface for searching models and implementing autosuggestion features on the front end
4. Speed up search performance
