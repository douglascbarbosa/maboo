<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BooksRequest;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:view,book')->only('show');
        $this->middleware('can:update,book')->only('update');
        $this->middleware('can:delete,book')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        return $this->showAll($user->books);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  BooksRequest $request
     * @return JsonResponse
     */
    public function store(BooksRequest $request)
    {

        $inputs = $request->all();

        $inputs['user_id'] = Auth::id();

        if($request->has('cover')) {
            $inputs['cover'] = $request->cover->store('');
        }

        $book = Book::create($inputs);

        return $this->showOne($book, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function show(Book $book)
    {
        return $this->showOne($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Book  $book
     * @return JsonResponse
     */
    public function update(Request $request, Book $book)
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
     * @param User $user
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user, $id)
    {
        $book = $this->findModelItem($user->books(), $id);

        Storage::delete($book->cover);
        $book->delete();

        return $this->showOne($book);
    }
}
