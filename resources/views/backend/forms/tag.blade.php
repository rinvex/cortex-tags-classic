{{-- Master Layout --}}
@extends('cortex/foundation::backend.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.backend') }} » {{ trans('cortex/taggable::common.tags') }} » {{ $tag->exists ? $tag->name : trans('cortex/taggable::common.create_tag') }}
@stop

@push('scripts')
    {!! JsValidator::formRequest(Cortex\Taggable\Http\Requests\Backend\TagFormRequest::class)->selector('#backend-tags-save') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($tag->exists)
        @include('cortex/foundation::backend.partials.confirm-deletion', ['type' => 'tag'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ $tag->exists ? $tag->name : trans('cortex/taggable::common.create_tag') }}</h1>
            <!-- Breadcrumbs -->
            {{ Breadcrumbs::render() }}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/taggable::common.details') }}</a></li>
                    @if($tag->exists) <li><a href="{{ route('backend.tags.logs', ['tag' => $tag]) }}">{{ trans('cortex/taggable::common.logs') }}</a></li> @endif
                    @if($tag->exists && $currentUser->can('delete-tags', $tag)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('backend.tags.delete', ['tag' => $tag]) }}" data-item-name="{{ $tag->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($tag->exists)
                            {{ Form::model($tag, ['url' => route('backend.tags.update', ['tag' => $tag]), 'method' => 'put', 'id' => 'backend-tags-save']) }}
                        @else
                            {{ Form::model($tag, ['url' => route('backend.tags.store'), 'id' => 'backend-tags-save']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-8">
                                    <div class="row">

                                        <div class="col-md-12">

                                            {{-- Name --}}
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                {{ Form::label('name', trans('cortex/taggable::common.name'), ['class' => 'control-label']) }}
                                                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.name'), 'data-slugify' => '#slug', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                                @if ($errors->has('name'))
                                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            {{-- Description --}}
                                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                {{ Form::label('description', trans('cortex/taggable::common.description'), ['class' => 'control-label']) }}
                                                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.description'), 'rows' => 5]) }}

                                                @if ($errors->has('description'))
                                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row">

                                        <div class="col-md-12">

                                            {{-- Slug --}}
                                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                                {{ Form::label('slug', trans('cortex/taggable::common.slug'), ['class' => 'control-label']) }}
                                                {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.slug'), 'required' => 'required']) }}

                                                @if ($errors->has('slug'))
                                                    <span class="help-block">{{ $errors->first('slug') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">

                                            {{-- Group --}}
                                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                                {{ Form::label('group', trans('cortex/taggable::common.group'), ['class' => 'control-label']) }}
                                                {{ Form::select('group', $groups, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/taggable::common.select_group'), 'data-tags' => 'true', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                                @if ($errors->has('group'))
                                                    <span class="help-block">{{ $errors->first('group') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">

                                            {{-- Sort Order --}}
                                            <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                                {{ Form::label('sort_order', trans('cortex/taggable::common.sort_order'), ['class' => 'control-label']) }}
                                                {{ Form::number('sort_order', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.sort_order'), 'required' => 'required']) }}

                                                @if ($errors->has('sort_order'))
                                                    <span class="help-block">{{ $errors->first('sort_order') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/taggable::common.reset'), ['class' => 'btn btn-default btn-flat', 'type' => 'reset']) }}
                                        {{ Form::button(trans('cortex/taggable::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::backend.partials.timestamps', ['model' => $tag])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
