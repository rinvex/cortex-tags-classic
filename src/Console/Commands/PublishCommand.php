<?php

declare(strict_types=1);

namespace Cortex\Taggable\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:taggable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Taggable Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/taggable:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-taggable-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-taggable-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-taggable-lang']);
    }
}
