<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbroadStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abroad_studies', function (Blueprint $table) {
            $table->id();
            $table->integer('cadry_id');
            $table->string('date1')->nullable();
            $table->string('date2')->nullable();
            $table->string('institute')->nullable();
            $table->string('direction')->nullable();
            $table->string('type_abroad')->nullable();
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
        Schema::dropIfExists('abroad_studies');
    }
}
