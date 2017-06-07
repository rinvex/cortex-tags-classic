<?php

declare(strict_types=1);

namespace Cortex\Taggable\Providers;

use Rinvex\Taggable\TaggableServiceProvider as BaseTaggableServiceProvider;
use Illuminate\Support\AggregateServiceProvider as BaseAggregateServiceProvider;

class AggregateServiceProvider extends BaseAggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        BaseTaggableServiceProvider::class,
        TaggableServiceProvider::class,
    ];
}
