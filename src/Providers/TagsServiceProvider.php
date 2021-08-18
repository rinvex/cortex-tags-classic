<?php

declare(strict_types=1);

namespace Cortex\Tags\Providers;

use Cortex\Tags\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Database\Eloquent\Relations\Relation;

class TagsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Map relations
        Relation::morphMap([
            'tag' => config('rinvex.tags.models.tag'),
        ]);
    }
}
