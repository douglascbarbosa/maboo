@extends('layouts.app')

@section('content')

<div class="container">

    {!! Form::open(['method' => 'POST', 'action' => 'BookController@store', 'files'=>true]) !!}

        {!! Form::hidden('user_id', $user_id) !!}

        <div class="form-group">
            {!! Form::label('photo_id', 'Photo cover') !!}
            {!! Form::file('photo_id', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('author', 'Author') !!}
            {!! Form::text('author', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('pages', 'Total pages') !!}
            {!! Form::text('pages', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-check">
            {!! Form::checkbox('read_book', 'value', false, ['class' => 'form-check-input']); !!}
            {!! Form::label('read_book', 'Read in the past', ['class' => 'form-check-label']) !!}        
        </div>    

        <div class="form-group">
            {!! Form::label('rate', 'Rate this book') !!}
            {!! Form::number('rate', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('finish_date', 'Finish date') !!}
            {!! Form::number('finish_date', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('finish_date', 'Finish date') !!}
            {!! Form::text('finish_date', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-check">
            {!! Form::checkbox('started_book', 'value', false, ['class' => 'form-check-input']); !!}
            {!! Form::label('started_book', 'In progress', ['class' => 'form-check-label']) !!}        
        </div>    

        <div class="form-group">
            {!! Form::label('start_date', 'Start date') !!}
            {!! Form::text('start_date', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('marker', 'Current page') !!}
            {!! Form::number('marker', 1, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Add book', ['class' => 'btn btn-primary']) !!}
        </div>


    {!! Form::close() !!}    

    @include('includes.form_errors')

</div>
@stop