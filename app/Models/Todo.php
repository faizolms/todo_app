<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Todo extends Model
{
    use HasApiTokens,HasFactory;

    protected $table = 'todo_lists';
    protected $fillable = [
        'body','is_complete','user_id'
    ];
}
