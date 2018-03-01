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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
