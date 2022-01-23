<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' =>'nullable',

        ]);
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
            $token = $user->createToken($request->device_name);

            return[
                'token' => $token,
            ];
        }
        return[
            'error' => 'Invalid username or password '  
        ];

    }
    public function logout(Request $request)
    {
        $user = $request->user();
        /*$user->api_token = null;
        $user->save();*/

        //$user->tokens()->delete();
        $user->currentAccesssToken()->delete();
        return[
            'logout' => 1,
        ];


    }
}
