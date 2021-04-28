<?php

namespace App\Http\Controllers;

use App\Models\NoteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make(
            $request->only(['title']),
            [
                'title' => 'required'
            ],
            [
                'title.required' => 'O título da nota é obrigatório!'
            ]
        );

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $user = $request->get('user');

        $note = NoteModel::create(['title' => $title, 'description' => $description, 'id_user' => $user['id']]);

        if($note){
            return response()->json(null, 201);
        }

        return response()->json(['message' => 'Não foi possível cadastrar a nota!'], 500);
    }

    public function list(Request $request)
    {

        if(!empty($id)){
            $note = NoteModel::select('title', 'description', 'created_at', 'updated_at')
                                    ->where('id', $id)
                                    ->where('id_user', 1)  
                                    ->first();
            echo $note;
        }
    }
}
