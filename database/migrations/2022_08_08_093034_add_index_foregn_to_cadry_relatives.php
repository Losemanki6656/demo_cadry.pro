<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForegnToCadryRelatives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadry_relatives', function (Blueprint $table) {
            //$table->BigInteger('cadry_id')->unsigned()->change();
            //$table->index('cadry_id');
            //$table->foreign('cadry_id')->references('id')->on('cadries');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadry_relatives', function (Blueprint $table) {
            //
        });
    }
}
