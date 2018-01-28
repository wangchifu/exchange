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
            'password' => bcrypt(env('DEFAULT_USER_PWD')),
            'name' => '王老師',
            'admin' => '1',
        ]);
    }
}