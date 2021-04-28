<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'id_user',
        'created_at',
        'updated_at'
    ];

    protected $table = 'note';
}
