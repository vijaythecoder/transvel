# Transvel
This package allows you to convert all files in `resources/lang/en` folder to required languages automatically. Its easy to configure and run simple command. 

### Dependencies
This package uses  [Dedicated Google Translate](https://github.com/ddctd143/google-translate/)

## Installation

Package can be installed using composer by adding to "require" object

```
"require": {
    "vijaytupakula/transvel": "dev-master"
}
```
now run `composer update` 

or from console:
```json
composer require vijaytupakula/transvel dev-master
```

now lets add class loader to `providers` array in `config/app.php` file
```php
Vijaytupakula\Transvel\TransvelServiceProvider::class
```
once the class loader is added, try to run `php artisan list` this should show `php artisan translate` command.

## Configuration
Now add your available langueges in the `config/app.php` as follows
```php
'locales' => ['en' => 'English', 'fr' => 'French', 'it' => 'Italian'],
```

## usage
Run `php artisan translate` : this command fetches all the files from `resources/lang/en` folder and then creates the files in each folders that are added as `locales` in `app/config.php` with translation using google api.

## Contact
Please feel free to contact me if you have problem using it. It works great for me :)