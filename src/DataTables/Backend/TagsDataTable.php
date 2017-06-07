<?php

declare(strict_types=1);

namespace Cortex\Taggable\DataTables\Backend;

use Cortex\Taggable\Models\Tag;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Taggable\Transformers\Backend\TagTransformer;

class TagsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Tag::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = TagTransformer::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => ['title' => trans('cortex/taggable::common.name'), 'render' => '"<a href=\""+routes.route(\'backend.tags.edit\', {tag: full.id})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'slug' => ['title' => trans('cortex/taggable::common.slug')],
            'created_at' => ['title' => trans('cortex/taggable::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/taggable::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
