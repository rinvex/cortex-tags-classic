<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.cortex.tags.tags.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tags::common.tags'), route('adminarea.cortex.tags.tags.index'));
});

Breadcrumbs::register('adminarea.cortex.tags.tags.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.cortex.tags.tags.import'));
});

Breadcrumbs::register('adminarea.cortex.tags.tags.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.cortex.tags.tags.import'));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.cortex.tags.tags.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.tags.tags.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.create_tag'), route('adminarea.cortex.tags.tags.create'));
});

Breadcrumbs::register('adminarea.cortex.tags.tags.edit', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(strip_tags($tag->name), route('adminarea.cortex.tags.tags.edit', ['tag' => $tag]));
});

Breadcrumbs::register('adminarea.cortex.tags.tags.logs', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(strip_tags($tag->name), route('adminarea.cortex.tags.tags.edit', ['tag' => $tag]));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.cortex.tags.tags.logs', ['tag' => $tag]));
});
