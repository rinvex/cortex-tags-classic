<?php

declare(strict_types=1);

use Cortex\Tags\Models\Tag;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('adminarea.cortex.tags.tags.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tags::common.tags'), route('adminarea.cortex.tags.tags.index'));
});

Breadcrumbs::for('adminarea.cortex.tags.tags.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.cortex.tags.tags.import'));
});

Breadcrumbs::for('adminarea.cortex.tags.tags.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.import'), route('adminarea.cortex.tags.tags.import'));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.cortex.tags.tags.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.tags.tags.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(trans('cortex/tags::common.create_tag'), route('adminarea.cortex.tags.tags.create'));
});

Breadcrumbs::for('adminarea.cortex.tags.tags.edit', function (Generator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(strip_tags($tag->name), route('adminarea.cortex.tags.tags.edit', ['tag' => $tag]));
});

Breadcrumbs::for('adminarea.cortex.tags.tags.logs', function (Generator $breadcrumbs, Tag $tag) {
    $breadcrumbs->parent('adminarea.cortex.tags.tags.index');
    $breadcrumbs->push(strip_tags($tag->name), route('adminarea.cortex.tags.tags.edit', ['tag' => $tag]));
    $breadcrumbs->push(trans('cortex/tags::common.logs'), route('adminarea.cortex.tags.tags.logs', ['tag' => $tag]));
});
