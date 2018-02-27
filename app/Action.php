<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
        'study_year',
        'kind',
        'name',
        'icon',
        'file_type',
        'groups',
        'enable',
    ];
}
