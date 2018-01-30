<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.taxonomy'), 10, 'fa fa-arrows', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.tags.index'], trans('cortex/tags::common.tags'), 20, 'fa fa-tags')->ifCan('list-tags')->activateOnRoute('adminarea.tags');
    });
});

Menu::register('adminarea.tags.tabs', function (MenuGenerator $menu, Tag $tag) {
    $menu->route(['adminarea.tags.create'], trans('cortex/tags::common.details'))->ifCan('create-tags')->if(! $tag->exists);
    $menu->route(['adminarea.tags.edit', ['tag' => $tag]], trans('cortex/tags::common.details'))->ifCan('update-tags')->if($tag->exists);
    $menu->route(['adminarea.tags.logs', ['tag' => $tag]], trans('cortex/tags::common.logs'))->ifCan('update-tags')->if($tag->exists);
});
