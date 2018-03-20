<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'pic',
        'pw',
        'username',
        'ip',
        'page',
        'action',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
