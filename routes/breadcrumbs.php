<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.tags.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tags::common.tags'), route('adminarea.tags.index'));
});

Breadcrumbs::register('adminarea.tags.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.tags.import'));
});

Breadcrumbs::register('adminarea.tags.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.tags.import'));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.tags.import.logs'));
});

Breadcrumbs::register('adminarea.tags.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.create_tag'), route('adminarea.tags.create'));
});

Breadcrumbs::register('adminarea.tags.edit', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.tags.index');
    $breadcrumbs->push($tag->name, route('adminarea.tags.edit', ['tag' => $tag]));
});

Breadcrumbs::register('adminarea.tags.logs', function (BreadcrumbsGenerator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.tags.index');
    $breadcrumbs->push($tag->name, route('adminarea.tags.edit', ['tag' => $tag]));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.tags.logs', ['tag' => $tag]));
});
