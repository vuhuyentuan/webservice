<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('banner')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'id' => '1',
                'logo' => 'AdminLTE-3.1.0/dist/img/AdminLTELogo.png',
                'logo_text' => 'DVMXH',
                'banner' => 'AdminLTE-3.1.0/dist/img/bg7.jpg',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
