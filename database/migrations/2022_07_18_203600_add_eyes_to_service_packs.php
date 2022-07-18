<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEyesToServicePacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_packs', function (Blueprint $table) {
            $table->enum('eyes', ['show', 'hide'])->default('hide')->after('feeling');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_packs', function (Blueprint $table) {
            //
        });
    }
}
