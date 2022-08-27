<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToMedicalExaminations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_examinations', function (Blueprint $table) {
            $table->BigInteger('cadry_id')->unsigned()->change();
            $table->index('cadry_id');
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->string('result')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_examinations', function (Blueprint $table) {
            //
        });
    }
}
