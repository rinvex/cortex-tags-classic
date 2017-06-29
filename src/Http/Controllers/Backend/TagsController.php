<?php

declare(strict_types=1);

namespace Cortex\Taggable\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Cortex\Taggable\Models\Tag;
use Illuminate\Support\Facades\DB;
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
        return app(TagsDataTable::class)->render('cortex/foundation::backend.partials.datatable', ['id' => 'cortex-taggable-tags', 'phrase' => trans('cortex/taggable::common.tags')]);
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
        return $this->process($request, new Tag());
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Taggable\Http\Requests\Backend\TagFormRequest $request
     * @param \Cortex\Taggable\Models\Tag                           $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        return $this->process($request, $tag);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Taggable\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Tag $tag)
    {
        $tag->delete();

        return intend([
            'url' => route('backend.tags.index'),
            'with' => ['warning' => trans('cortex/taggable::messages.tag.deleted', ['tagId' => $tag->id])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Taggable\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Tag $tag)
    {
        $groups = DB::table(config('rinvex.taggable.tables.tags'))->distinct()->select(['group'])->get()->pluck('group', 'group')->toArray();

        return view('cortex/taggable::backend.forms.tag', compact('tag', 'groups'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \Cortex\Taggable\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, Tag $tag)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save tag
        $tag->fill($data)->save();

        return intend([
            'url' => route('backend.tags.index'),
            'with' => ['success' => trans('cortex/taggable::messages.tag.saved', ['tagId' => $tag->id])],
        ]);
    }
}
