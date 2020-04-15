<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookSession;
use App\Http\Requests\BookSessionRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookSessionController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Book $book
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Book $book)
    {
        $this->authorize('view', $book);
        return $this->showAll($book->bookSessions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookSessionRequest $request
     * @param Book $book
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(BookSessionRequest $request, Book $book)
    {
        $this->authorize('createSession', $book);

        $inputs = $request->all();

        # creating the session
        $bookSession = BookSession::create($inputs);

        # changing the book marker to the current page
        $book->addPages($bookSession->read_pages);

        # return the saved page
        return $this->showOne($bookSession, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Book $book, int $id)
    {
        $this->authorize('view', $book);

        $bookSession = $this->findModelItem($book->bookSessions(), $id);
        return $this->showOne($bookSession);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Book $book, int $id)
    {
        $this->authorize('update', $book);

        $bookSession = $this->findModelItem($book->bookSessions(), $id);

        $diffPages = $bookSession->read_pages - $request->read_pages;

        $bookSession->fill($request->only([
            'read_pages',
            'time',
            'date',
        ]));

        if($bookSession->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $bookSession->save();

        if ($diffPages > 0) {
            $book->addPages($diffPages);
        }

        return $this->showOne($bookSession);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Book $book, $id)
    {
        $this->authorize('delete', $book);

        $bookSession = $this->findModelItem($book->bookSessions(), $id);
        $bookSession->delete();

        $book->subPages($bookSession->read_pages);

        return $this->showOne($bookSession);

    }
}
