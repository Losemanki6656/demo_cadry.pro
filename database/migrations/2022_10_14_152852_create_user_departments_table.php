<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('emmat_department_id')->unsigned()->index()->nullable();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('emmat_department_id')->references('id')->on('emmat_departments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('pass')->nullable();
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
        Schema::dropIfExists('user_departments');
    }
}
