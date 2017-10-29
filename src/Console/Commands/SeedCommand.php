<?php

declare(strict_types=1);

namespace Cortex\Tags\Console\Commands;

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
    protected $signature = 'cortex:seed:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Tags Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);

        if ($this->ensureExistingDatabaseTables('rinvex/fort')) {
            $this->seedResources(app('rinvex.fort.ability'), realpath(__DIR__.'/../../../resources/data/abilities.json'), ['name', 'description', 'policy']);
        }
    }
}
