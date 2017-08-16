<?php

declare(strict_types=1);

namespace Cortex\Taggable\Providers;

use Illuminate\Support\ServiceProvider;
use Cortex\Taggable\Console\Commands\SeedCommand;
use Cortex\Taggable\Console\Commands\MigrateCommand;

class TaggableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/taggable');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/taggable');
        $this->commands([SeedCommand::class, MigrateCommand::class]);
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/taggable')], 'lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/taggable')], 'views');
    }
}
