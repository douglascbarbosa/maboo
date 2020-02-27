<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends ApiController
{
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $client = DB::table('oauth_clients')
        ->where('password_client', true)
        ->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $data);
        $content = json_decode(app()->handle($requestToken)->getContent());

        if (!isset($content->access_token)) {
            return $this->errorResponse($content->message, 401);    
        }

        $user = User::where('email', $request->email)->first();

        return $this->showData([
            'user' => $user,
            'token' => $content->access_token,
            'refresh_token' => $content->refresh_token
        ]);   
    }       
}
