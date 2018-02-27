<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'action_id',
        'user_id',
        'username',
        'file_name',
        'upload_time',
    ];
}
