<?php

namespace NormanHuth\VHostTool;

use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/installers.php', 'installers',
        );
        $this->mergeConfigFrom(
            __DIR__.'/config/tool.php', 'tool',
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/installers.php' => config_path('installers.php'),
        ], 'tool-installers-config');
        $this->publishes([
            __DIR__.'/config/tool.php' => config_path('tool.php'),
        ], 'tool-config');
    }
}
