@extends('layouts.app')

@section('content')

<div class="container">
    <a href="{{ route('book.create') }}" class="btn btn-primary">New Book</a>
    <div class="row">

        @if ($books)
       
            @foreach ($books as $book)

                <div class="col mb-4">
                    <div class="card h-100" >
                        <img src="https://images-na.ssl-images-amazon.com/images/I/71Q1Iu4suSL._SY606_.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$book->title}}</h5>
                            <p class="card-text">{{$book->author}}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            
            @endforeach

        @endif
    </div>


<!--    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection
