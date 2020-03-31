<?php

namespace App\Policies;

use App\User;
use App\Book;

class BookPolicy
{

    /**
     * Determine whether the user can view the book.
     *
     * @param User $user
     * @param Book  $book
     * @return bool
     */
    public function view(User $user, Book $book)
    {
        return $user->id === $book->user_id;
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  User  $user
     * @param  Book  $book
     * @return bool
     */
    public function update(User $user, Book $book)
    {
        return $user->id === $book->user_id;
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  User  $user
     * @param  Book  $book
     * @return bool
     */
    public function delete(User $user, Book $book)
    {
        return $user->id === $book->user_id;
    }

}
