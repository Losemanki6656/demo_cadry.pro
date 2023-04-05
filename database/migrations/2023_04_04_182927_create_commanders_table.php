<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commanders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->bigInteger('country_id')->unsigned()->index()->nullable();
            $table->bigInteger('commander_payment_id')->unsigned()->index()->nullable();
            $table->bigInteger('commander_pupose_id')->unsigned()->index()->nullable();
            $table->string('position')->nullable();
            $table->string('command_number')->nullable();
            $table->date('date_command')->nullable();
            $table->date('date1')->nullable();
            $table->date('date2')->nullable();
            $table->string('days')->nullable(); 
            $table->string('reason')->nullable(); 
            $table->boolean('status')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('commander_payment_id')->references('id')->on('commander_payments');
            $table->foreign('commander_pupose_id')->references('id')->on('commander_puposes');
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
        Schema::dropIfExists('commanders');
    }
}
