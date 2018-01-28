<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::truncate();

        Group::create([
            'name' => '管理群組',
        ]);
        Group::create([
            'name' => '幼兒園',
        ]);
        Group::create([
            'name' => '國小註冊',
        ]);
        Group::create([
            'name' => '國中註冊',
        ]);
        Group::create([
            'name' => '高中職註冊',
        ]);
    }
}
