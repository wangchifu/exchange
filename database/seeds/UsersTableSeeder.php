<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'username' => env('ADMIN_USERNAME'),
            'password' => bcrypt(env('DEFAULT_USER_PWD')), //2jgugxou
            'name' => '縣府管理者',
            'admin' => '1',
            'group_id'=>'1',
        ]);


    }
}