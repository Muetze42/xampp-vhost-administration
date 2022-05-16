<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('phpSlug')) {
    /**
     * @param string $string
     * @return string
     */
    function phpSlug(string $string): string
    {
        return slug(basename($string));
    }
}

if (!function_exists('slug')) {
    /**
     * @param string $title
     * @param string $separator
     * @param string $language
     * @return string
     */
    function slug(string $title, string $separator = '-', string $language = 'en'): string
    {
        return Str::slug($title, $separator, $language);
    }
}

if (!function_exists('_asset')) {
    /**
     * @param $asset
     * @return string
     */
    function _asset($asset): string
    {
        $asset = $asset[0]!='/' ? '/'.$asset:$asset;

        $file = public_path().$asset;

        if (file_exists($file)) {
            return asset($asset.'?='.filemtime($file));
        }
        return '<!-- '.$asset.' not found -->';
    }
}

if (!function_exists('winSep'))
{
    /**
     * @param string $string
     * @return string
     */
    function winSep(string $string): string
    {
        return trim(str_replace('/', '\\', trim($string)), '\\');
    }
}

if (!function_exists('unixSep'))
{
    /**
     * @param string $string
     * @return string
     */
    function unixSep(string $string): string
    {
        return trim(str_replace('\\', '/', trim($string)), '/');
    }
}

if (!function_exists('siteTitle')) {
    function siteTitle(): string
    {
        $route = Route::currentRouteName();
        $parts = explode('.', $route);

        if (empty($parts[1])) {
            return $parts[0];
        }

        $name[] = $parts[1] == 'index' ? ucfirst($parts[0]) : ucfirst(singular($parts[0]));
        $name[] = ucfirst($parts[1]);

        return implode(' ', $name);
    }
}

if (!function_exists('cleanUpHost')) {
    /**
     * Temporary Function @Todo Create Subdomain Validation Rule
     *
     * @param string|null $string $string
     * @return string
     */
    function cleanUpHost(?string $string): string
    {
        return preg_replace('/[^a-zA-Z0-9-.]+/', '', trim($string));
    }
}

if (!function_exists('singular')) {
    /**
     * @param string $string
     * @return string
     */
    function singular(string $string): string
    {
        return Str::singular($string);
    }
}

if (!function_exists('prepareLine')) {
    /**
     * @param string $string
     * @return string
     */
    function prepareLine(string $string): string
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}

if (!function_exists('longestArrayValue')) {
    function longestArrayValue(array $array): int
    {
        if (!count($array)) {
            return 0;
        }

        return max(array_map('strlen', $array));
    }
}

if (!function_exists('isLaravel')) {
    function isLaravel(string $path): bool
    {
        $path = basename($path) == 'public' ? dirname($path, 1) : $path;

        // return is_dir($path.'/vendor/laravel/framework'); # Short, but only if installed

        $files = [
            'artisan',
        ];

        foreach ($files as $file) {
            if (!is_file($path.'/'.$file)) {
                return false;
            }
        }

        $folders = [
            'app',
            'bootstrap',
            'config',
            'database',
            'public',
            'routes',
            'storage',
        ];

        foreach ($folders as $folder) {
            if (!is_dir($path.'/'.$folder)) {
                return false;
            }
        }

        if (is_dir($path.'/vendor/laravel/framework')) {
            return true;
        }

        return false;
    }
}

if (!function_exists('isWordPress')) {
    function isWordPress(string $path): bool
    {
        $files = [
            'wp-login.php',
            'wp-settings.php',
        ];

        foreach ($files as $file) {
            if (!is_file($path.'/'.$file)) {
                return false;
            }
        }

        $folders = [
            'wp-admin',
            'wp-content',
            'wp-includes',
        ];

        foreach ($folders as $folder) {
            if (!is_dir($path.'/'.$folder)) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('replaceInFile')) {
    /**
     * Replace the given string in the given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $file
     * @return void
     */
    function replaceInFile(string $search, string $replace, string $file)
    {
        if (file_exists($file)) {
            file_put_contents(
                $file,
                str_replace($search, $replace, file_get_contents($file))
            );
        }
    }
}

if (!function_exists('dbName')) {
    function dbName(string $string): string
    {
        return Str::slug(str_replace(['.', '-'], '-', $string), '_');
    }
}

if (!function_exists('formatPHPVersion')) {
    function formatPHPVersion(string $version): string
    {
        $parts = explode('.', $version);

        return $parts[0].'.'.$parts[1];
    }
}
