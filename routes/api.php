<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user', [App\Http\Controllers\UserController::class, 'register']);

Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);

Route::group(['middleware' => ['jwt']], function() {
    Route::post('/note', [App\Http\Controllers\NoteController::class, 'register']);
    Route::get('/note/{id}', [App\Http\Controllers\NoteController::class, 'listOne']);
    Route::get('/note', [App\Http\Controllers\NoteController::class, 'list']);
    Route::put('/note/{id}', [App\Http\Controllers\NoteController::class, 'update']);
    Route::delete('/note/{id}', [App\Http\Controllers\NoteController::class, 'delete']);
});
