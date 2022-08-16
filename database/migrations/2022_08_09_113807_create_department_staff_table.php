<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('staff_id')->unsigned()->index()->nullable();
            $table->bigInteger('classification_id')->unsigned()->index()->nullable();
            $table->text('staff_full')->nullable();
            $table->double('stavka')->default(1);
            $table->boolean('status')->default(false);
            $table->boolean('status_decret')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('classification_id')->references('id')->on('classifications');
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
        Schema::dropIfExists('department_staff');
    }
}
