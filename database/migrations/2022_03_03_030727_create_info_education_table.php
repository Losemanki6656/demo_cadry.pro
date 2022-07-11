<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_education', function (Blueprint $table) {
            $table->id();
            $table->integer('cadry_id');
            $table->integer('sort');
            $table->string('date1');
            $table->string('date2');
            $table->text('institut');
            $table->text('speciality');
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
        Schema::dropIfExists('info_education');
    }
}
