Laravel 4+ Searchy
========================================
### Database Searching Made Easy

Searchy is an easy-to-use Laravel 4+ package that makes running user driven searches on data in your models simple and effective.
It uses pseudo fuzzy searching and other weighted mechanics depending on the search driver that you have enabled.
It requires no other software installed on your server (so a bit slower than dedicated search programs) but can be set up and ready to go in minutes.

Installation
----------------------------------------
Add `"tom-lingham/searchy" : "1.*"` to your composer.json file under `require`:
```
"require": {
	"laravel/framework": "4.*",
	"tom-lingham/searchy" : "1.*"
}
```
Run `composer update` in your terminal to pull the package down into your vendors folder.

Add the service provider to the `providers` array in Laravel's app/config/app.php file:
```php
'TomLingham\Searchy\SearchyServiceProvider'
```

Add the Alias to the `aliases` array in Laravel's app/config/app.php file:
```php
'Searchy' => 'TomLingham\Searchy\Facades\Searchy'
```


Usage
----------------------------------------
To use Searchy, you can take advantage of magic methods.

If you are searching the name and email column/field of users in a `users` table you would, for example run:
```php
$users = Searchy::users('name', 'email')->query('John Smith');
```
you can also write this as:

```php
$users = Searchy::search('users')->fields('name', 'email')->query('John Smith');
```
In this case, pass the columns you want to search through to the `fields()` method.

These examples both return a Laravel DB Query Builder Object, so you will need to chain `get()` to actually return the results in a usable object:

```php
$users = Searchy::search('users')->fields('name', 'email')->query('John Smith')->get();
```

#### Searching multiple Columns
You can also add multiple arguments to the list of fields/columns to search by.

For example, if you want to search the name, email address and username of a user, you might run:
```php
$users = Searchy::users('name', 'email', 'username')->query('John Smith');
```

#### Searching Joined/Concatenated Columns
Sometimes you may want to leverage searches on concatenated column. For example, on a `first_name` and `last_name` field but you only want to run the one query. To do this can separate columns with a double colon:
```php
$users = Searchy::users('first_name::last_name')->query('John Smith');
```

Configuration
----------------------------------------
You can publish the configuration file to your `app` directory and override the settings by running `php artisan config:publish tom-lingham/searchy`

You can set the default driver to use for searches in the configuration file. Your options (at this stage) are: `fuzzy`, `simple` and `levenshtein`.

You can also override these methods using the following syntax when running a search:

```php
Searchy::driver('fuzzy')->users('name')->query('Bat Man')->get();
```


Drivers
----------------------------------------
Searchy takes advantage of 'Drivers' to handle matching various conditions of the fields you specify.

Drivers are simply a specified group of 'Matchers' which match strings based on specific conditions.

Currently there are only three drivers: Simple, Fuzzy and Levenshtein (Experimental).

#### Simple Search Driver
The Simple search driver only uses 3 matchers each with the relevant multipliers that best suited my testing environments.

```php

protected $matchers = [
	'TomLingham\Searchy\Matchers\ExactMatcher'                 => 100,
	'TomLingham\Searchy\Matchers\StartOfStringMatcher'         => 50,
	'TomLingham\Searchy\Matchers\InStringMatcher'              => 30,
];

```


#### Fuzzy Search Driver
The Fuzzy Search Driver is simply another group of matchers setup as follows. The multipliers are what I have used, but feel free to change these or roll your own driver with the same matchers and change the multipliers to suit.

```php

protected $matchers = [
	'TomLingham\Searchy\Matchers\ExactMatcher'                 => 100,
	'TomLingham\Searchy\Matchers\StartOfStringMatcher'         => 50,
	'TomLingham\Searchy\Matchers\AcronymMatcher'               => 42,
	'TomLingham\Searchy\Matchers\ConsecutiveCharactersMatcher' => 40,
	'TomLingham\Searchy\Matchers\StartOfWordsMatcher'          => 35,
	'TomLingham\Searchy\Matchers\StudlyCaseMatcher'            => 32,
	'TomLingham\Searchy\Matchers\InStringMatcher'              => 30,
	'TomLingham\Searchy\Matchers\TimesInStringMatcher'         => 8,
];
	
```

#### Levenshtein Search Driver (Experimental)
The Levenshtein Search Driver uses the Levenshetein Distance to calculate the 'distance' between strings. It requires that you have a stored procedure in MySQL similar to the following `levenshtein( string1, string2 )`. There is an SQL file with a suitable function in the `res` folder - feel free to use this one.

```php

protected $matchers = [
	'TomLingham\Searchy\Matchers\LevenshteinMatcher' => 100
];
	
```

Matchers
----------------------------------------

#### ExactMatcher
Matches an exact string and applies a high multiplier to bring any exact matches to the top.
When sanitize is on, if the expression strips some of the characters from the search query then this may not be able to match against a string despite entering in an exact match.


#### StartOfStringMatcher
Matches Strings that begin with the search string.
For example, a search for 'hel' would match; 'Hello World' or 'helping hand'


#### AcronymMatcher
Matches strings for Acronym 'like' matches but does NOT return Studly Case Matches
For example, a search for 'fb' would match; 'foo bar' or 'Fred Brown' but not 'FreeBeer'.


#### ConsecutiveCharactersMatcher
Matches strings that include all the characters in the search relatively positioned within the string. It also calculates the percentage of characters in the string that are matched and applies the multiplier accordingly.
For Example, a search for 'fba' would match; 'Foo Bar' or 'Afraid of bats', but not 'fabulous'


#### StartOfWordsMatcher
Matches the start of each word against each word in a search.
For example, a search for 'jo ta' would match; 'John Taylor' or 'Joshua B. Takeshi'


#### StudlyCaseMatcher
Matches Studly Case strings using the first letters of the words only
For example a search for 'hp' would match; 'HtmlServiceProvider' or 'HashParser' but not 'hasProvider'


#### InStringMatcher
Matches against any occurrences of a string within a string and is case-insensitive.
For example, a search for 'smi' would match; 'John Smith' or 'Smiley Face'


#### TimesInStringMatcher
Matches a string based on how many times the search string appears inside the string it then applies the multiplier for each occurrence.
For example, a search for 'tha' would match; 'I hope that that cat has caught that mouse' (3 x multiplier) or 'Thanks, it was great!' (1 x multiplier)


#### LevenshteinMatcher
See *Levenshtein Driver*


Extending
----------------------------------------
#### Drivers
It's really easy to roll your own search drivers. Simply create a class that extends `TomLingham\Searchy\SearchDrivers\BaseSearchDriver` and add a property called `$matchers` with an array of matcher classes as the key and the multiplier for each matcher as the values. You can pick from the classes that are already included with Searchy or you can create your own.

#### Matchers
To create your own matchers, you can create your own class that extends `TomLingham\Searchy\Matchers\BaseMatcher` and (for simple Matchers) override the `formatQuery` method to return a string formatted with `%` wildcards in required locations. For more advanced extensions you may need to override the `buildQuery` method and others as well.


Contributing & Reporting Bugs
----------------------------------------
If you would like to improve on the code that is here, feel free to submit a pull request.
If you find any bugs, submit them here and I will respond as soon as possible. Please make sure to include as much information as possible.