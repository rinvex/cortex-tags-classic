<?php

declare(strict_types=1);

namespace Cortex\Tags\Providers;

use Cortex\Tags\Models\Tag;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Cortex\Tags\Console\Commands\SeedCommand;
use Cortex\Tags\Console\Commands\InstallCommand;
use Cortex\Tags\Console\Commands\MigrateCommand;
use Cortex\Tags\Console\Commands\PublishCommand;
use Cortex\Tags\Console\Commands\RollbackCommand;
use Illuminate\Database\Eloquent\Relations\Relation;

class TagsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.tags.seed',
        InstallCommand::class => 'command.cortex.tags.install',
        MigrateCommand::class => 'command.cortex.tags.migrate',
        PublishCommand::class => 'command.cortex.tags.publish',
        RollbackCommand::class => 'command.cortex.tags.rollback',
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
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.tags.models.tag'] === Tag::class
        || $this->app->alias('rinvex.tags.tag', Tag::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        // Bind route models and constrains
        $router->pattern('tag', '[a-zA-Z0-9-]+');
        $router->model('tag', config('rinvex.tags.models.tag'));

        // Map relations
        Relation::morphMap([
            'tag' => config('rinvex.tags.models.tag'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs/adminarea.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tags');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tags');
        $this->app->runningInConsole() || $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus/adminarea.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesLang('cortex/tags');
        ! $this->app->runningInConsole() || $this->publishesViews('cortex/tags');
        ! $this->app->runningInConsole() || $this->publishesMigrations('cortex/tags');
    }
}
