<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\User;

class UserController extends ApiController
{

    public function __construct()
    {
        // parent::__construct();

        $this->middleware('client.credentials')->only(['index', 'show', 'update', 'destroy']);        
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();

        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
                
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);
        
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email' . $user->id,
            'password' => 'min:6|confirmed'
        ];

        $this->validate($request, $rules);

        if($request->has('name'))
        {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email)
        {
            $user->email = $request->email;
        }

        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }

        if(!$user->isDirty()) 
        {
            return $this->errorResponse('You need to specify a different value to update ', 422);
        }

        $user->save();        

        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }
}
