<?php

declare(strict_types=1);

namespace Cortex\Tags\DataTables\Adminarea;

use Cortex\Tags\Models\Tag;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Tags\Transformers\Adminarea\TagTransformer;

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
     * {@inheritdoc}
     */
    protected $order = [
        [1, 'asc'],
        [0, 'asc'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $builderParameters = [
        'rowGroup' => '{
            dataSrc: \'group\'
        }',
    ];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.cortex.tags.tags.edit\', {tag: full.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.cortex.tags.tags.edit\', {tag: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'name' => ['title' => trans('cortex/tags::common.name'), 'render' => $link, 'responsivePriority' => 0],
            'group' => ['title' => trans('cortex/tags::common.group'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/tags::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/tags::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}
