<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadryRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadry_relatives', function (Blueprint $table) {
            $table->id();
            $table->integer('cadry_id');
            $table->integer('relative_id');
            $table->integer('sort');
            $table->string('fullname');
            $table->string('birth_place');
            $table->text('post');
            $table->text('address');
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
        Schema::dropIfExists('cadry_relatives');
    }
}
