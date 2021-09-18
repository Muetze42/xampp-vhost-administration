# Xampp VHost Administration

## Quickstart
* Clone or download this app
* Make sure that SQLite enabled in your `/xampp/php/php.ini`
* Run `composer install`
* Run `php artisan install`

## Config
* Copy `.env.example` to `.env` and set up `APP_URL` the files under `# XAMPP Settings`, `# Tool Settings` and `# Installer Settings`
* Run `php artisan vendor:publish --tag=tool-installers-config` to set up `config/installers.php` for the App Installers
* Run `php artisan vendor:publish --tag=tool-config` to set up the tool

---

### Optional (Examples with PHP 7.4 as second PHP version and installation path C:/xampp)
* Install other PHP versions in the Xampp folder (`C:/xampp/php/php74`, `C:/xampp/php/php73` etc, folder names with `.` are excluded)
* **Copy** `C:/xampp/php/php74/php.exe` to `C:/xampp/php/php74/php74.exe`
* Create the file `C:/xampp/php/php74/composer74.cmd` with the following content: 
```
C:/xampp/php/php74.exe c:/ProgramData/ComposerSetup/bin/composer.phar %*
```
* Add the folder `C:/xampp/php/php74` as path to the Windows environment variables

Now open cmd and test
```
php -v
php74 -v
composer -v
composer74 -v
```

To install dependencies with PHP 7.4 use
```
composer74 install
```

You can find ready PHP versions for XAMPP [here](https://github.com/Muetze42/xampp-php)
