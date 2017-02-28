@extends('admin.index')
@section('content')
    <h1>Categories</h1>

    <div class="row">
        {!! Form::model($category,['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Category name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Update category', ['class' => 'btn btn-primary col-sm-6']) !!}
        </div>

        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}

        <div class="form-group">
            {!! Form::submit('Delete category', ['class' => 'btn btn-danger col-sm-6']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection