<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_directions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('apparat_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('staff_name')->nullable();
            $table->integer('time_lesson')->default(0);
            $table->string('comment_time')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('training_directions');
    }
}
