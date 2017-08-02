<?php

declare(strict_types=1);

use Cortex\Taggable\Models\Tag;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('backend.tags.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.backend'), route('backend.home'));
    $breadcrumbs->push(trans('cortex/taggable::common.tags'), route('backend.tags.index'));
});

Breadcrumbs::register('backend.tags.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('backend.tags.index');
    $breadcrumbs->push(trans('cortex/taggable::common.create_tag'), route('backend.tags.create'));
});

Breadcrumbs::register('backend.tags.edit', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('backend.tags.index');
    $breadcrumbs->push($tag->name, route('backend.tags.edit', ['tag' => $tag]));
});

Breadcrumbs::register('backend.tags.logs', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('backend.tags.index');
    $breadcrumbs->push($tag->name, route('backend.tags.edit', ['tag' => $tag]));
    $breadcrumbs->push(trans('cortex/taggable::common.logs'), route('backend.tags.logs', ['tag' => $tag]));
});
