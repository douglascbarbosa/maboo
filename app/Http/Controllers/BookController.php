<?php

namespace App\Http\Controllers;
use App\User;
use App\Book; 
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\BooksRequest;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index($userId)
    // {
    //     return Book::ofUser($userId)->paginate();
    // }
    public function index() 
    {
        return view('book.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user_id = Auth::user()->id;

        return view('book.create', compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BooksRequest $request)
    {

        
        $input = $request->all();

        if($file = $request->file('photo_id')) {
            $name = time() . '_' .  $file->getClientOriginalName();
            
            $file->move('images', $name);

            $photo = Photo::create(['path' => $name]);

            $input['photo_id'] = $photo->id;

        }


        Book::create($input);

        return redirect('/home');

/*        $user = User::findOrFail($userId);

        $user->books()->save(new Book([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'pages' => $request->input('pages'),
            'marker' => $request->input('marker'),
        ]));
        
        return $user->books;
        */

        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
