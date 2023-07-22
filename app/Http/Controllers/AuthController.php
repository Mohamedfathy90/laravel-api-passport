<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','string'],
            'email'=>['required','email','unique:users,email'],
            'password'=>['required','confirmed']
        ]);
        $credentials['password']=Hash::make($request->password);
        $user=User::create($credentials);
        $token=$user->createToken($request->name)->accessToken;

        return response([
            'user'=> $user , 
            'token'=>$token
        ],201);
    }
}
