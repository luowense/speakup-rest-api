<?php

namespace App\Api\V1\Controllers;

use App\Role;
use App\Ticket;
use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUpUser(SignUpRequest $request, JWTAuth $JWTAuth, Ticket $ticket)
    {
        $user = new User();
        $user->role_id = 1;
        $user->name = 'Anonyme';
        $user->email = 'fake@' . uniqid() . '.com';
        $user->password = uniqid();

        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }

    public function signUpPsy(SignUpRequest $request, JWTAuth $JWTAuth, Ticket $ticket)
    {
        $user = new User($request->all());
        $user->role_id = 2;

        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }
}
