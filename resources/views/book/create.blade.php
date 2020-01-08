@extends('layouts.app')

@section('content')

<div class="container">

{!! Form::open(['method' => 'POST', 'action' => 'BookController@store']) !!}

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

    <div class="form-group">
        {!! Form::submit('Add book', ['class' => 'btn btn-primary']) !!}
    </div>


{!! Form::close() !!}    

</div>
@stop