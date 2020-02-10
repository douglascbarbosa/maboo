<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BooksRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends ApiController
{

    public function __construct()
    {
        // $this->middleware('client.credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        
        return $this->showAll($books);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BooksRequest $request, User $user)
    {

        $inputs = $request->all();

        $inputs['user_id'] = $user->id;
        
        if($request->has('cover')) {
            $inputs['cover'] = $request->cover->store('');
        }

        $book = Book::create($inputs);

        return $this->showOne($book, 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Book $book)
    {
        return $this->showOne($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Book $book)
    {
        $book->fill($request->only([
            'title',
            'author',
            'pages',
            'rate',
            'marker',
            'planning_date',
            'start_date',
            'finish_date',
            'cover'
        ]));


        if($request->has('cover')) {
            Storage::delete($book->cover);
            
            $book->cover = $request->cover->store('');
        }

        if($book->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $book->save();

        return $this->showOne($book);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Book $book)
    {
        Storage::delete($book->cover);
        $book->delete();

        return $this->showOne($book);
    }
}
