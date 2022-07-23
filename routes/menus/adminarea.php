<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.taxonomy'), 10, 'fa fa-arrows', 'header', [], [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.tags.tags.index'], trans('cortex/tags::common.tags'), 20, 'fa fa-tags')->ifCan('list', app('rinvex.tags.tag'))->activateOnRoute('adminarea.cortex.tags.tags');
    });
});

Menu::register('adminarea.cortex.tags.tags.tabs', function (MenuGenerator $menu, Tag $tag) {
    $menu->route(['adminarea.cortex.tags.tags.import'], trans('cortex/tags::common.records'))->ifCan('import', $tag)->if(Route::is('adminarea.cortex.tags.tags.import*'));
    $menu->route(['adminarea.cortex.tags.tags.import.logs'], trans('cortex/tags::common.logs'))->ifCan('audit', $tag)->if(Route::is('adminarea.cortex.tags.tags.import*'));
    $menu->route(['adminarea.cortex.tags.tags.create'], trans('cortex/tags::common.details'))->ifCan('create', $tag)->if(Route::is('adminarea.cortex.tags.tags.create'));
    $menu->route(['adminarea.cortex.tags.tags.edit', ['tag' => $tag]], trans('cortex/tags::common.details'))->ifCan('update', $tag)->if($tag->exists);
    $menu->route(['adminarea.cortex.tags.tags.logs', ['tag' => $tag]], trans('cortex/tags::common.logs'))->ifCan('audit', $tag)->if($tag->exists);
});
