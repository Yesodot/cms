@extends('layouts.admin')


@section('content')

    <h1>Edit Posts</h1>



    <div class="row">

        <div class="col-sm-3">
            <img src="{{$post->photo->file}}" alt="" class="img-responsive img-circle">
        </div>


        <div class="col-sm-6">


        {!! Form::model($post,['method' => 'PATCH', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('category_id', 'Category') !!}
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo_id', 'Photo') !!}
            {!! Form::file('photo_id', ['class' => 'btn btn-primary btn-file']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('body', 'Description') !!}
            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 6]) !!}
        </div>


        <div class="form-group">
            {!! Form::submit('Update Post', ['class' => 'btn btn-primary col-sm-4']) !!}
        </div>

        {!! Form::close() !!}


        {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
            <div class="form-group">
                {!! Form::submit('Delete Post', ['class' => 'btn btn-danger col-sm-4 pull-right']) !!}
            </div>
        {!! Form::close() !!}
    </div>




    </div>

    <div class="row">
        @include('includes.form_errors')
    </div>

@stop
