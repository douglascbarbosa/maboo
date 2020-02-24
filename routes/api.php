<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('books', [ 'as' => 'books', function () {
//     return App\Book::all();
// }]);

// Route::get('users', function () {
//     return App\User::all();
// });

// Route::resource('user.books', 'BookController', ['only' => ['index', 'store', 'update']]);

Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);

Route::resource('user.books', 'BookController', ['except' => ['create', 'edit']]);

Route::resource('book.sessions', 'BookSessionController', ['except' => ['create', 'edit']]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');