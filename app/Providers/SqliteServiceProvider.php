<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SqliteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $databaseFile = config('database.connections.sqlite.database');
        if ($databaseFile && !file_exists($databaseFile) && file_exists(base_path('.env'))) {
            file_put_contents($databaseFile, '');
        }
    }
}
