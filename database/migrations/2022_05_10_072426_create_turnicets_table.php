<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnicetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnicets', function (Blueprint $table) {
            $table->id();
            $table->integer('railway_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string(('organization_name'));
            $table->string(('department_name'));
            $table->integer(('tabel'));
            $table->string(('fullname'));
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
        Schema::dropIfExists('turnicets');
    }
}
