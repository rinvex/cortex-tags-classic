<?php

declare(strict_types=1);

namespace Cortex\Tags\Console\Commands;

use Rinvex\Tags\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:tags {--force : Overwrite any existing files.}';

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
    public function handle(): void
    {
        parent::handle();

        $this->call('vendor:publish', ['--tag' => 'cortex-tags-lang', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-tags-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-tags-migrations', '--force' => $this->option('force')]);
    }
}
