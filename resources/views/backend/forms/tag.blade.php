{{-- Master Layout --}}
@extends('cortex/foundation::backend.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.backend') }} » {{ trans('cortex/taggable::common.tags') }} » {{ $tag->exists ? $tag->slug : trans('cortex/taggable::common.create_tag') }}
@stop

{{-- Main Content --}}
@section('content')

    @if($tag->exists)
        @include('cortex/foundation::backend.partials.confirm-deletion', ['type' => 'tag'])
    @endif

    <div class="content-wrapper">
        <!-- Breadcrumbs -->
        <section class="content-header">
            <h1>{{ $tag->exists ? $tag->slug : trans('cortex/taggable::common.create_tag') }}</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> {{ trans('cortex/foundation::common.backend') }}</a></li>
                <li><a href="{{ route('backend.tags.index') }}">{{ trans('cortex/taggable::common.tags') }}</a></li>
                <li class="active">{{ $tag->exists ? $tag->slug : trans('cortex/taggable::common.create_tag') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            @if ($tag->exists)
                {{ Form::model($tag, ['url' => route('backend.tags.update', ['tag' => $tag]), 'method' => 'put']) }}
            @else
                {{ Form::model($tag, ['url' => route('backend.tags.store')]) }}
            @endif

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#details" data-toggle="tab">{{ trans('cortex/taggable::common.details') }}</a></li>
                        @if($tag->exists) <li><a href="{{ route('backend.tags.logs', ['tag' => $tag]) }}">{{ trans('cortex/taggable::common.logs') }}</a></li> @endif
                        @if($tag->exists && $currentUser->can('delete-tags', $tag)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('backend.tags.delete', ['tag' => $tag]) }}" data-item-name="{{ $tag->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="details">

                            <div class="row">

                                <div class="col-md-6">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/taggable::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.name'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/taggable::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('slug') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/taggable::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('cortex/taggable::common.description'), 'rows' => 3]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
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

                    </div>

                </div>

            {{ Form::close() }}

        </section>

    </div>

@endsection
