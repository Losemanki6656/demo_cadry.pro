<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_cadries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_staff_id')->unsigned()->index()->nullable();
            $table->bigInteger('staff_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->double('stavka')->default(1);
            $table->text('staff_full')->nullable();
            $table->boolean('status_sv')->default(false);
            $table->boolean('status')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('department_staff_id')->references('id')->on('department_staff');
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
        Schema::dropIfExists('department_cadries');
    }
}
