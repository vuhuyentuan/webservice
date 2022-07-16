<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('role')->default(0);
            $table->string('name');
            $table->string('code_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('bank_image')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_branch')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('recovery_password')->nullable();
            $table->string('phone')->nullable();
            $table->integer('amount')->default(0);
            $table->string('user_token')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_original')->nullable();
            $table->integer('banned_status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
