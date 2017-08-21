<?php

declare(strict_types=1);

namespace Cortex\Taggable\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:taggable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Taggable Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Install cortex/taggable:');
        $this->call('cortex:migrate:taggable');
        $this->call('cortex:seed:taggable');
        $this->call('cortex:publish:taggable');
    }
}
