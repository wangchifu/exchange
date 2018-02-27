<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewStuDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_stu_data', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('username');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('action_id');
            $table->string('stu_sn');
            $table->string('stu_name');
            $table->string('stu_sex');
            $table->string('stu_id');
            $table->string('stu_birthday');
            $table->string('stu_date');
            $table->string('stu_school');
            $table->string('stu_address');
            $table->string('stu_ps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_stu_data');
    }
}
