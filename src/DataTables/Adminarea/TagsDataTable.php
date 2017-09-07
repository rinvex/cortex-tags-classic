<?php

declare(strict_types=1);

namespace Cortex\Taggable\DataTables\Adminarea;

use Rinvex\Taggable\Contracts\TagContract;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Taggable\Transformers\Adminarea\TagTransformer;

class TagsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = TagContract::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = TagTransformer::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = app($this->model)->query()->orderBy('group', 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return [
            'keys' => true,
            'autoWidth' => false,
            'dom' => "<'row'<'col-sm-6'B><'col-sm-6'f>> <'row'r><'row'<'col-sm-12't>> <'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons' => [
                ['extend' => 'create', 'text' => '<i class="fa fa-plus"></i> '.trans('cortex/foundation::common.new')], 'print', 'reset', 'reload', 'export',
                ['extend' => 'colvis', 'text' => '<i class="fa fa-columns"></i> '.trans('cortex/foundation::common.columns').' <span class="caret"/>'],
            ],
            'drawCallback' => 'function (settings) {
                var lastGroup = null;
                var api = this.api();
                var colspan = api.columns(\':visible\').count();
                var rows = api.rows({page:\'current\'}).nodes();

                api.column(\'group:name\', {page:\'current\'} ).data().each(function (rowGroup, rowIndex) {
                    if (lastGroup !== rowGroup) {
                        $(rows).eq(rowIndex).before(
                            \'<tr class="tag-group"><td colspan="\'+colspan+\'"><strong>\'+(rowGroup ? rowGroup : "No Group")+\'</strong></td></tr>\'
                        );
     
                        lastGroup = rowGroup;
                    }
                });
            }',
        ];
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $transformer = app($this->transformer);

        return datatables()->eloquent($this->query())
                           ->setTransformer($transformer)
                           ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
                           ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => ['title' => trans('cortex/taggable::common.name'), 'render' => '"<a href=\""+routes.route(\'adminarea.tags.edit\', {tag: full.slug})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'slug' => ['title' => trans('cortex/taggable::common.slug')],
            'group' => ['title' => trans('cortex/taggable::common.group'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/taggable::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/taggable::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
