<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServicePackIdToServiceBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_bills', function (Blueprint $table) {
            $table->integer('service_pack_id')->unsigned()->nullable()->after('service_id');
            $table->foreign('service_pack_id')->references('id')->on('service_packs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_bills', function (Blueprint $table) {
            //
        });
    }
}
