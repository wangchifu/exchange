<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $fillable = [
        'from',
        'for',
        'title',
        'file_name',
        'file',
        'upload_time',
        'download',
    ];
}
