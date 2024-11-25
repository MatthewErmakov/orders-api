<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->only('email', 'password');

        if ( !Auth::attempt($data) ) {
            return response()->json([
                'error' => [
                    'message' => 'Login or password are incorrect.'
                ]
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token');

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only('name', 'email', 'password');

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User created successfully.',
            'token' => $user->createToken("Personal Access Token")->plainTextToken
        ], 200);
    }
}
