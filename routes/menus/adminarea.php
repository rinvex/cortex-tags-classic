<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Tag $tag) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.taxonomy'), 10, 'fa fa-arrows', 'header', [], function (MenuItem $dropdown) use ($tag) {
        $dropdown->route(['adminarea.tags.index'], trans('cortex/tags::common.tags'), 20, 'fa fa-tags')->ifCan('list', $tag)->activateOnRoute('adminarea.tags');
    });
});

Menu::register('adminarea.tags.tabs', function (MenuGenerator $menu, Tag $tag) {
    $menu->route(['adminarea.tags.import'], trans('cortex/tags::common.records'))->ifCan('import', $tag)->if(Route::is('adminarea.tags.import*'));
    $menu->route(['adminarea.tags.import.logs'], trans('cortex/tags::common.logs'))->ifCan('import', $tag)->if(Route::is('adminarea.tags.import*'));
    $menu->route(['adminarea.tags.create'], trans('cortex/tags::common.details'))->ifCan('create', $tag)->if(Route::is('adminarea.tags.create'));
    $menu->route(['adminarea.tags.edit', ['tag' => $tag]], trans('cortex/tags::common.details'))->ifCan('update', $tag)->if($tag->exists);
    $menu->route(['adminarea.tags.logs', ['tag' => $tag]], trans('cortex/tags::common.logs'))->ifCan('audit', $tag)->if($tag->exists);
});
