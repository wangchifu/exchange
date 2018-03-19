<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'pic',
        'ip',
        'page',
        'action',
        'user_id'
    ];
}
