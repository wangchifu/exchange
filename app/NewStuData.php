<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewStuData extends Model
{
    protected $table = 'new_stu_data';
    protected $fillable = [
        'user_id',
        'username',
        'group_id',
        'action_id',
        'stu_sn',
        'stu_name',
        'stu_sex',
        'stu_id',
        'stu_birthday',
        'stu_date',
        'stu_school',
        'stu_address',
        'stu_ps',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
