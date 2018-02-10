<?php

declare(strict_types=1);

namespace Cortex\Tags\Http\Controllers\Adminarea;

use Rinvex\Tags\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Tags\DataTables\Adminarea\TagsDataTable;
use Cortex\Tags\Http\Requests\Adminarea\TagFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class TagsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'tag';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Tags\DataTables\Adminarea\TagsDataTable $tagsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TagsDataTable $tagsDataTable)
    {
        return $tagsDataTable->with([
            'id' => 'adminarea-tags-index-table',
            'phrase' => trans('cortex/tags::common.tags'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Tag $tag, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $tag,
            'tabs' => 'adminarea.tags.tabs',
            'phrase' => trans('cortex/tags::common.tags'),
            'id' => "adminarea-tags-{$tag->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\View\View
     */
    public function form(Tag $tag)
    {
        $groups = app('rinvex.tags.tag')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tags::adminarea.pages.tag', compact('tag', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Tags\Http\Requests\Adminarea\TagFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(TagFormRequest $request)
    {
        return $this->process($request, app('rinvex.tags.tag'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Tags\Http\Requests\Adminarea\TagFormRequest $request
     * @param \Rinvex\Tags\Models\Tag                             $tag
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        return $this->process($request, $tag);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Rinvex\Tags\Models\Tag                 $tag
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Tag $tag)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save tag
        $tag->fill($data)->save();

        return intend([
            'url' => route('adminarea.tags.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'tag', 'id' => $tag->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Tag $tag)
    {
        $tag->delete();

        return intend([
            'url' => route('adminarea.tags.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'tag', 'id' => $tag->slug])],
        ]);
    }
}
