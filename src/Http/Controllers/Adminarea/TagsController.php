<?php

declare(strict_types=1);

namespace Cortex\Tags\Http\Controllers\Adminarea;

use Cortex\Tags\Models\Tag;
use Illuminate\Http\Request;
use Cortex\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\InsertImporter;
use Cortex\Tags\DataTables\Adminarea\TagsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Tags\Http\Requests\Adminarea\TagFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class TagsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rinvex.tags.models.tag';

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
            'id' => 'adminarea-cortex-tags-tags-index',
            'routePrefix' => 'adminarea.cortex.tags.tags',
            'pusher' => ['entity' => 'tag', 'channel' => 'cortex.tags.tags.index'],
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
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
            'tabs' => 'adminarea.cortex.tags.tags.tabs',
            'id' => "adminarea-cortex-tags-tags-{$tag->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import tags.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\InsertImporter        $importer
     * @param \Cortex\Tags\Models\Tag                            $tag
     *
     * @return void
     */
    public function import(ImportFormRequest $request, InsertImporter $importer, Tag $tag)
    {
        $importer->withModel($tag)->import($request->file('file'));
    }

    /**
     * Create new tag.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Cortex\Tags\Models\Tag  $tag
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Tag $tag)
    {
        return $this->form($request, $tag);
    }

    /**
     * Edit given tag.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Cortex\Tags\Models\Tag  $tag
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Tag $tag)
    {
        return $this->form($request, $tag);
    }

    /**
     * Show tag create/edit form.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Cortex\Tags\Models\Tag  $tag
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Tag $tag)
    {
        if (! $tag->exists && $request->has('replicate') && $replicated = $tag->resolveRouteBinding($request->input('replicate'))) {
            $tag = $replicated->replicate();
        }

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
     * @param \Cortex\Foundation\Http\FormRequest $request
     * @param \Cortex\Tags\Models\Tag             $tag
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
            'url' => route('adminarea.cortex.tags.tags.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/tags::common.tag'), 'identifier' => $tag->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given tag.
     *
     * @param \Cortex\Tags\Models\Tag $tag
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return intend([
            'url' => route('adminarea.cortex.tags.tags.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/tags::common.tag'), 'identifier' => $tag->getRouteKey()])],
        ]);
    }
}
