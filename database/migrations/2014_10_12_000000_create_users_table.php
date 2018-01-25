<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password', 60);
            $table->integer('type');
            $table->string('name');
            $table->string('name_en');
            $table->string('email');
            $table->string('address');
            $table->string('bank_name');
            $table->string('bank_name_en');
            $table->string('bank_address');
            $table->string('bank_account');
            $table->string('bank_user_name');
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
        Schema::drop('users');
    }
}
