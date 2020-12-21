<?php

declare(strict_types=1);

namespace Cortex\Tags\Database\Seeders;

use Illuminate\Database\Seeder;

class CortexTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List tags', 'entity_type' => 'tag'],
            ['name' => 'import', 'title' => 'Import tags', 'entity_type' => 'tag'],
            ['name' => 'create', 'title' => 'Create tags', 'entity_type' => 'tag'],
            ['name' => 'update', 'title' => 'Update tags', 'entity_type' => 'tag'],
            ['name' => 'delete', 'title' => 'Delete tags', 'entity_type' => 'tag'],
            ['name' => 'audit', 'title' => 'Audit tags', 'entity_type' => 'tag'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
