<?php

declare(strict_types=1);

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
        Bouncer::allow('admin')->to('list', config('rinvex.tags.models.tag'));
        Bouncer::allow('admin')->to('create', config('rinvex.tags.models.tag'));
        Bouncer::allow('admin')->to('update', config('rinvex.tags.models.tag'));
        Bouncer::allow('admin')->to('delete', config('rinvex.tags.models.tag'));
        Bouncer::allow('admin')->to('audit', config('rinvex.tags.models.tag'));
    }
}
