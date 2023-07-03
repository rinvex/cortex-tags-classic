<?php

declare(strict_types=1);

namespace Cortex\Tags\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Rinvex\Tags\Console\Commands\RollbackCommand as BaseRollbackCommand;

#[AsCommand(name: 'cortex:rollback:tags')]
class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:tags {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Tags Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $path = config('cortex.tags.autoload_migrations') ?
            realpath(__DIR__.'/../../../database/migrations') :
            $this->laravel->databasePath('migrations/cortex/tags');

        if (file_exists($path)) {
            $this->call('migrate:reset', [
                '--path' => $path,
                '--realpath' => true,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:tags</>');
        }

        parent::handle();
    }
}
