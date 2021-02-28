<?php

declare(strict_types=1);

namespace Cortex\Tags\Http\Controllers\Adminarea;

use Exception;
use Cortex\Tags\Models\Tag;
use Illuminate\Http\Request;
use Cortex\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Tags\DataTables\Adminarea\TagsDataTable;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Tags\Http\Requests\Adminarea\TagFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
     * @param \Cortex\Tags\Models\Tag                              $tag
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Tag $tag, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $tag,
            'tabs' => 'adminarea.cortex.tags.tags.tabs',
            'url' => route('adminarea.cortex.tags.tags.stash'),
            'id' => "adminarea-cortex-tags-tags-{$tag->getRouteKey()}-import",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash tags.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard tags.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->input('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.tags.tag')->getFillable()))->toArray();

                tap(app('rinvex.tags.tag')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
    }

    /**
     * List tag import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => trans('cortex/tags::common.tag'),
            'tabs' => 'adminarea.cortex.tags.tags.tabs',
            'id' => 'adminarea-cortex-tags-tags-import-logs',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
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
