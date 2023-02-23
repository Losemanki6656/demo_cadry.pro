<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_cadries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->date('period1')->nullable();
            $table->date('period2')->nullable();
            $table->date('date1')->nullable();
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
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
        Schema::dropIfExists('vacation_cadries');
    }
}
