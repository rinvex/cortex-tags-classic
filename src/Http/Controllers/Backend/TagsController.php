<?php

declare(strict_types=1);

namespace Cortex\Taggable\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Rinvex\Taggable\Contracts\TagContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Taggable\DataTables\Backend\TagsDataTable;
use Cortex\Taggable\Http\Requests\Backend\TagFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class TagsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'tags';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app(TagsDataTable::class)->with([
            'id' => 'cortex-taggable-tags',
            'phrase' => trans('cortex/taggable::common.tags'),
        ])->render('cortex/foundation::backend.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(TagContract $tag)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'tags',
            'resource' => $tag,
            'id' => 'cortex-taggable-tags-logs',
            'phrase' => trans('cortex/taggable::common.tags'),
        ])->render('cortex/foundation::backend.pages.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Taggable\Http\Requests\Backend\TagFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagFormRequest $request)
    {
        return $this->process($request, app('rinvex.taggable.tag'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Taggable\Http\Requests\Backend\TagFormRequest $request
     * @param \Rinvex\Taggable\Contracts\TagContract                $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TagFormRequest $request, TagContract $tag)
    {
        return $this->process($request, $tag);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Taggable\Contracts\TagContract $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(TagContract $tag)
    {
        $tag->delete();

        return intend([
            'url' => route('backend.tags.index'),
            'with' => ['warning' => trans('cortex/taggable::messages.tag.deleted', ['slug' => $tag->slug])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Taggable\Contracts\TagContract $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function form(TagContract $tag)
    {
        $groups = app('rinvex.taggable.tag')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/taggable::backend.forms.tag', compact('tag', 'groups'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request               $request
     * @param \Rinvex\Taggable\Contracts\TagContract $tag
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, TagContract $tag)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save tag
        $tag->fill($data)->save();

        return intend([
            'url' => route('backend.tags.index'),
            'with' => ['success' => trans('cortex/taggable::messages.tag.saved', ['slug' => $tag->slug])],
        ]);
    }
}
