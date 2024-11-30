<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPinnedQuestion extends Model
{
    protected $fillable = [
        'user_id',
        'question_id'
    ];
}
