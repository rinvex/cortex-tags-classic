<?php

declare(strict_types=1);

namespace Cortex\Taggable\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Support\Traits\SeederHelper;

class SeedCommand extends Command
{
    use SeederHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:taggable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Default Cortex Taggable data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Seed cortex/taggable:');

        if ($this->ensureExistingDatabaseTables('rinvex/fort')) {
            $this->seedResources(app('rinvex.fort.ability'), realpath(__DIR__.'/../../../resources/data/abilities.json'), ['name', 'description']);
        }
    }
}
