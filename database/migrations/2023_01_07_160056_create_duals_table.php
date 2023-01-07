<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->bigInteger('technical_id')->unsigned()->index()->nullable();
            $table->bigInteger('specialty_id')->unsigned()->index()->nullable();

            $table->boolean('status')->default(false);
            $table->date('date1')->nullable();
            $table->date('date2')->nullable();
            $table->string('file_path')->nullable();
            
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('technical_id')->references('id')->on('technicals');
            $table->foreign('specialty_id')->references('id')->on('specialties');
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
        Schema::dropIfExists('duals');
    }
}
