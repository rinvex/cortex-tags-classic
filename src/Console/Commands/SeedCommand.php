<?php

declare(strict_types=1);

namespace Cortex\Taggable\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Fort\Traits\AbilitySeeder;
use Cortex\Fort\Traits\BaseFortSeeder;
use Illuminate\Support\Facades\Schema;

class SeedCommand extends Command
{
    use AbilitySeeder;
    use BaseFortSeeder;

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
        if ($this->ensureExistingTaggableTables()) {
            // No seed data at the moment!
        }

        if ($this->ensureExistingFortTables()) {
            $this->seedAbilities(realpath(__DIR__.'/../../../resources/data/abilities.json'));
        }
    }

    /**
     * Ensure existing taggable tables.
     *
     * @return bool
     */
    protected function ensureExistingTaggableTables()
    {
        if (! $this->hasTaggableTables()) {
            $this->call('cortex:migrate:taggable');
        }

        return true;
    }

    /**
     * Check if all required taggable tables exists.
     *
     * @return bool
     */
    protected function hasTaggableTables()
    {
        return Schema::hasTable(config('rinvex.taggable.tables.tags'))
               && Schema::hasTable(config('rinvex.taggable.tables.taggables'));
    }
}
