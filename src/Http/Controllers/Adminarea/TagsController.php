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
     * List all tags.
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
     * List tag logs.
     *
     * @param \Cortex\Tags\Models\Tag                     $tag
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
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
     * Create new tag.
     *
     * @param \Cortex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\View\View
     */
    public function create(Tag $tag)
    {
        return $this->form($tag);
    }

    /**
     * Edit given tag.
     *
     * @param \Cortex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\View\View
     */
    public function edit(Tag $tag)
    {
        return $this->form($tag);
    }

    /**
     * Show tag create/edit form.
     *
     * @param \Cortex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\View\View
     */
    protected function form(Tag $tag)
    {
        $groups = app('rinvex.tags.tag')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tags::adminarea.pages.tag', compact('tag', 'groups'));
    }

    /**
     * Store new tag.
     *
     * @param \Cortex\Tags\Http\Requests\Adminarea\TagFormRequest $request
     * @param \Cortex\Tags\Models\Tag                             $tag
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(TagFormRequest $request, Tag $tag)
    {
        return $this->process($request, $tag);
    }

    /**
     * Update given tag.
     *
     * @param \Cortex\Tags\Http\Requests\Adminarea\TagFormRequest $request
     * @param \Cortex\Tags\Models\Tag                             $tag
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        return $this->process($request, $tag);
    }

    /**
     * Process stored/updated tag.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Tags\Models\Tag                 $tag
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'tag', 'id' => $tag->name])],
        ]);
    }

    /**
     * Destroy given tag.
     *
     * @param \Cortex\Tags\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return intend([
            'url' => route('adminarea.tags.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'tag', 'id' => $tag->name])],
        ]);
    }
}
