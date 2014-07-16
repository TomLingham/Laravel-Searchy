Laravel 4+ Searchy
========================================
### Database Searching Made Easy

Searchy is an easy-to-use Laravel 4+ package that makes running user driven searches on data in your models simple and effective.
It uses pseudo fuzzy searching and other weighted mechanics depending on the search driver that you have enabled.
It requires no other software installed on your server (so a bit slower than dedicated search programs) but can be setup and ready to go in minutes.

Installation
----------------------------------------
Add to your composer.json file under `require`:
```
"tom-lingham/searchy" : "dev-master"
```

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

#### Searching multiple Columns
You can also add multiple arguments ot the list fo fields/columns ot search by.

For example, if you want to search the name, email address and username of a user, you might run:
```
$users = Searchy::users('name', 'email', 'username')->query('John Smith');
```


Configuration
----------------------------------------
You can publish the configuration file to your `app` directory and override the settings by running `php artisan config:publish tom-lingham/searchy`

You can set the default driver to use for searches in the configuration file. Your options (At this stage) are: `fuzzy`, `simple` and `levenshtein`.

You can also override these methods using the following syntax when running a search:

```
Searchy::driver('fuzzy')->users('name')->query('Bat Man')->get();
```


Drivers
----------------------------------------
Searchy takes advantage of 'Drivers' to handle matching various conditions of the fields you specify.

Drivers are simply a specified group of 'Matchers' which match strings based on different conditions.

Currently there are only three drivers: Simple, Fuzzy and Levenshtein (Experimental).


Extending
----------------------------------------
#### Drivers
It's really easy to roll your own search drivers. Simply create a class that extends TomLingham\Searchy\SearchDrivers\BaseSearchDriver and add a property called `$matchers` with an array of matcher classes as the key and the multiplier as the values. You can pick from the classes that are already included with Searchy or you can create your own.

#### Matchers
To create your own matchers, you can create your own class that extends TomLingham\Searchy\Matchers\BaseMatcher and (for simple Matchers) override the `formatQuery` method to return a string formatted with `%` wildcards in required locations. For more advanced extensions you may need to override the `buildQuery` method and others as well.


Contributing & Reporting Bugs
----------------------------------------
If you would like to improve on the code that is here, feel free to submit a pull request.
If you find any bugs, submit them here and I will respond as soon as possible. Please make sure to include as much information as possible.


Road Map
----------------------------------------
To the future! The intention is to (eventually):

1. Remove Searchy's dependancy on Laravel
2. Include more drivers for more advanced searching (Including file system searching, indexing and more)
3. Implement an AJAX friendly interface for searching models and implementing autosuggestion features on the front end
4. Speed up search performance
