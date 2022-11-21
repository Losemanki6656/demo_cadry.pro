<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadryCreatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadry_creates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->string('command_number')->nullable();
            $table->boolean('update_staff')->default(false);
            $table->boolean('status')->default(false);
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('cadry_creates');
    }
}
