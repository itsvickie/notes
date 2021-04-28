<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
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
        $password = Hash::make($request->input('password'));

        $user = UserModel::select('id')
                            ->where('username', $username)
                            ->first();

        if($user){
            return response()->json(['message' => 'Nome de Usuário já cadastrado!'], 500);
        }
        
        $user = UserModel::create(['username' => $username, 'password' => $password]);

        if($user){
            return response()->json(null, 201);
        }

        return response()->json(['message' => 'Não foi possível cadastrar o usuário!'], 500);
    }
}