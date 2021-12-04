<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('user')->attempt($validator->validated())) {
            return response()->json([
                'error'   => 'incorrect_credentials',
                'message' => 'Incorrect email or password!'
            ], 500);
        }

        return response()->json($this->createNewToken($token), 200);
    }

    /**
     * @param $token
     *
     * @return array
     */
    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('user')->factory()->getTTL() * 60,
            'user'         => auth('user')->user()
        ];
    }
}
