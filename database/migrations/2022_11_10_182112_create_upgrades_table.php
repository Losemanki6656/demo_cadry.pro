<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpgradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->bigInteger('apparat_id')->unsigned()->index()->nullable();
            $table->bigInteger('training_direction_id')->unsigned()->index()->nullable();
            $table->integer('type_training')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('dataqual')->nullable();
            $table->boolean('status_bedroom')->default(false);
            $table->date('date1')->nullable();
            $table->date('date2')->nullable();
            $table->string('group_number')->nullable();
            $table->string('teachers')->nullable();
            $table->string('type_test')->nullable();
            $table->integer('ball')->nullable();
            $table->boolean('status_training')->default(false);
            $table->string('file_path')->nullable();
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('training_direction_id')->references('id')->on('training_directions');
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->foreign('apparat_id')->references('id')->on('apparats');
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
        Schema::dropIfExists('upgrades');
    }
}
