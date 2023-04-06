<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->string('browser')->nullable();
            $table->string('version')->nullable();
            $table->string('platform')->nullable();
            $table->string('ipAddress')->nullable();
            $table->string('countryName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('regionCode')->nullable();
            $table->string('regionName')->nullable();
            $table->string('cityName')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('areaCode')->nullable();
            $table->string('timezone')->nullable();
            $table->string('pathInfo')->nullable();
            $table->string('requestUri')->nullable();
            $table->string('method')->nullable();
            $table->string('userAgent')->nullable();
            $table->text('content')->nullable();
            $table->string('header')->nullable();
            $table->string('device')->nullable();
            $table->string('other')->nullable();
            $table->boolean('status')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_events');
    }
}
