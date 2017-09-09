<?php

declare(strict_types=1);

namespace Cortex\Tags\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Tags Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/tags:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-tags-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tags-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tags-lang']);
    }
}
