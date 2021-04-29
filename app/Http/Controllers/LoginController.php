<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make(
            $request->only(['username', 'password']),
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'O nome de usuário é obrigatório!',
                'password.required' => 'A senha é obrigatória!'
            ]
        );

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $username = $request->input('username');

        $user = UserModel::where('username', $username)->first(['id', 'password']);
        
        if(empty($user)){
            return response()->json(['message' => 'Usuário não encontrado!'], 401);
        }

        $password = $request->input('password');

        if(!Hash::check($password, $user['password'])){
            return response()->json(['message' => 'Senha incorreta!'], 401);
        }

        return response()->json(['token' => Helper::Jwt(['id' => $user['id']])]);
    }
}