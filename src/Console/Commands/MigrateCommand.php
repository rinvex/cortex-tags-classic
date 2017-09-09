<?php

declare(strict_types=1);

namespace Cortex\Taggable\Console\Commands;

use Rinvex\Tags\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:taggable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Taggable Tables.';
}
