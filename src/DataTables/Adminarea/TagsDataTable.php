<?php

declare(strict_types=1);

namespace Cortex\Tags\DataTables\Adminarea;

use Cortex\Tags\Models\Tag;
use Cortex\Foundation\DataTables\AbstractDataTable;

class TagsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Tag::class;

    /**
     * {@inheritdoc}
     */
    protected $builderParameters = [
        'rowGroup' => '{
            dataSrc: \'group\'
        }',
    ];

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $locale = app()->getLocale();
        $query = app($this->model)->query()->orderBy('group', 'ASC')->orderBy('sort_order', 'ASC')->orderBy("title->\${$locale}", 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->orderColumn('title', 'title->"$.'.app()->getLocale().'" $1')
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
            ? '"<a href=\""+routes.route(\'adminarea.tags.edit\', {tag: hashids.encode(full.id), locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.tags.edit\', {tag: hashids.encode(full.id)})+"\">"+data+"</a>"';

        return [
            'title' => ['title' => trans('cortex/tags::common.title'), 'render' => $link, 'responsivePriority' => 0],
            'group' => ['title' => trans('cortex/tags::common.group'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/tags::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/tags::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
