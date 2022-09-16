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
            $table->string('number_order')->nullable();
            $table->integer('main_day')->default(15);
            $table->integer('for_staff')->default(0);
            $table->integer('for_experience')->default(0);
            $table->integer('for_climate')->default(0);
            $table->integer('for_other')->default(0);
            $table->integer('for_hardwork')->default(0);
            $table->integer('underage')->default(0);
            $table->integer('invalid')->default(0);
            $table->integer('invalid_child')->default(0);
            $table->integer('childrens')->default(0);
            $table->integer('donor')->default(0);
            $table->integer('more')->default(0);
            $table->date('period1')->nullable();
            $table->date('period2')->nullable();
            $table->date('date1')->nullable();
            $table->date('date2')->nullable();
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
