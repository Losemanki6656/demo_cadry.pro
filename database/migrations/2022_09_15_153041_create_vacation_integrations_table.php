<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_integrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->integer('main_day')->default(15);
            $table->integer('for_staff')->default(0);
            $table->integer('for_staj')->default(0);
            $table->integer('for_klimat')->default(0);
            $table->integer('for_other')->default(0);
            $table->integer('for_ogirmehnat')->default(0);
            $table->integer('yoshgat')->default(0);
            $table->integer('nogiron')->default(0);
            $table->integer('nogironfarzand')->default(0);
            $table->integer('yoshfarzand')->default(0);
            $table->integer('donor')->default(0);
            $table->integer('qoshimcha')->default(0);
            $table->integer('period1')->default(0);
            $table->integer('period2')->default(0);
            $table->integer('date1')->default(0);
            $table->integer('date2')->default(0);
            $table->integer('alldays')->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('status_suc')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('vacation_integrations');
    }
}
