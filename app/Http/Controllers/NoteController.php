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

    public function listOne(Request $request, $id)
    {
        $note = NoteModel::select('title', 'description', 'created_at', 'updated_at')
                            ->where('id', $id)
                            ->first();

        if($note){
            return response()->json($note, 200);
        }

        return response()->json(['message' => 'Nota não encontrada!'], 400);
    }

    public function list(Request $request)
    {
        $user = $request->get('user');

        $note = NoteModel::select('id', 'title', 'description', 'created_at', 'updated_at')
                            ->where('id_user', $user['id'])
                            ->orderBy('created_at', 'ASC')
                            ->get();

        if($note){
            return response()->json($note, 200);
        }

        return response()->json(['message' => 'Usuário sem notas cadastradas!'], 400);
    }

    public function update(Request $request, $id)
    {
        $note = NoteModel::find($id);

        if($note){
            $title = $request->input('title');
            $description = $request->input('description');

            if($title){
                $note->title = $title;
            }
            
            if($description){
                $note->description = $description;
            }

            if($note->save()){
                return response()->json(null, 200);
            }
        }

        return response()->json(['message' => 'Nota não encontrada!']);
    }

    public function delete(Request $request, $id)
    {
        $note = NoteModel::find($id);

        if($note){
            if($note->delete()){
                return response()->json(null, 200);
            }
        }

        return response()->json(['message' => 'Nota não encontrada!'], 500);
    }
}