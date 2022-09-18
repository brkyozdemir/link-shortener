<?php

namespace App\Auth\Controllers;

use App\Auth\Handlers\AuthHandler;
use App\Auth\Requests\SignupRequest;
use App\Auth\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use League\Fractal\Resource\Item;

class AuthController extends Controller
{
    public function signup(SignupRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = AuthHandler::signup($request->all());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        $resource = new Item($user, new UserTransformer, 'user');

        return $this->response($user, $resource, Response::HTTP_CREATED, false);
    }

    public function getOauthToken(Request $request): Response
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $request->offsetSet('grant_type', 'password');
        $request->offsetSet('client_id', 2);
        $request->offsetSet('client_secret', AuthHandler::getGrantClientSecret());

        $tokenRequest = Request::create(
            '/oauth/token',
            'post'
        );

        return Route::dispatch($tokenRequest);
    }
}
