<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
        'study_year',
        'user_id',
        'kind',
        'name',
        'file_type',
        'groups',
        'enable',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
