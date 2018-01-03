<?php

declare(strict_types=1);

namespace Cortex\Tags\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Tags Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);

        $this->call('cortex:migrate:tags');
        $this->call('cortex:seed:tags');
        $this->call('cortex:publish:tags');
    }
}
