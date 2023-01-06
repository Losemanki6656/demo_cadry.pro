<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionTechnicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_technicals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->bigInteger('technical_id')->unsigned()->index()->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('technical_id')->references('id')->on('technicals');
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
        Schema::dropIfExists('position_technicals');
    }
}
