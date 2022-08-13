<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForeginToVacations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->BigInteger('cadry_id')->unsigned()->change();
            $table->BigInteger('railway_id')->unsigned()->change();
            $table->BigInteger('organization_id')->unsigned()->change();
            $table->date('date_next')->nullable()->change();
            $table->index('cadry_id');
            $table->index('railway_id');
            $table->index('organization_id');
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            //
        });
    }
}
