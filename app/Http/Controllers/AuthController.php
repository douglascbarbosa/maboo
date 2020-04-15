<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use AuthenticatesUsers, ApiResponser;

    /**
     * @inheritDoc
     */
    protected function authenticated(Request $request, $user)
    {

        $client = DB::table('oauth_clients')
        ->where('password_client', true)
        ->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->request->get('email')
        ]);

        // forward the request to the oauth token request endpoint
        $tokenRequest = Request::create(
            '/oauth/token',
            'post',
            (array)$request->request
        );

        return Route::dispatch($tokenRequest);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function refresh(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string',
        ]);

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'grant_type' => 'refresh_token',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'refresh_token' => $request->token,
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $data);
        $content = json_decode(app()->handle($requestToken)->getContent());

        if (!isset($content->access_token)) {
            return $this->errorResponse($content->message, 401);
        }

        return $this->showData([
            'token' => $content->access_token,
            'refresh_token' => $content->refresh_token
        ]);
    }


}
