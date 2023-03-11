<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->year('year')->deault(0);
            $table->integer('month')->deault(0);
            $table->json('days')->nullable();
            $table->foreign('cadry_id')->references('id')->on('cadries');
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
        Schema::dropIfExists('tabels');
    }
}
