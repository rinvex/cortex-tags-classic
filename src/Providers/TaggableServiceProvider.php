<?php

declare(strict_types=1);

namespace Cortex\Taggable\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Cortex\Taggable\Console\Commands\SeedCommand;
use Cortex\Taggable\Console\Commands\InstallCommand;
use Cortex\Taggable\Console\Commands\MigrateCommand;
use Cortex\Taggable\Console\Commands\PublishCommand;
use Rinvex\Tags\Contracts\TagContract;

class TaggableServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cortex.taggable.migrate',
        PublishCommand::class => 'command.cortex.taggable.publish',
        InstallCommand::class => 'command.cortex.taggable.install',
        SeedCommand::class => 'command.cortex.taggable.seed',
    ];

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
        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Bind route models and constrains
        $router->pattern('tag', '[a-z0-9-]+');
        $router->model('tag', TagContract::class);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/taggable');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/taggable');
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
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/taggable')], 'cortex-taggable-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/taggable')], 'cortex-taggable-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
