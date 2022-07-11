<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_cadries', function (Blueprint $table) {
            $table->id();
            $table->integer('cadry_id')->unsigned()->nullable();
            $table->integer('railway_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('birth_region_id')->unsigned()->nullable();
            $table->integer('birth_city_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('pass_region_id')->unsigned()->nullable();
            $table->integer('pass_city_id')->unsigned()->nullable();
            $table->integer('address_region_id')->unsigned()->nullable();
            $table->integer('address_city_id')->unsigned()->nullable();
            $table->integer('education_id')->unsigned()->nullable();
            $table->integer('staff_id')->unsigned()->nullable();
            $table->integer('nationality_id')->unsigned()->nullable();
            $table->integer('party_id')->unsigned()->nullable();
            $table->integer('academictitle_id')->unsigned()->nullable();
            $table->integer('academicdegree_id')->unsigned()->nullable();
            $table->integer('worklevel_id')->unsigned()->nullable();
            $table->string('military_rank');
            $table->string('deputy');
            $table->string('stavka');
            $table->string('photo');
            $table->string('language');
            $table->string('phone');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->date('birht_date');
            $table->date('post_date');
            $table->text('post_name');
            $table->string('passport');
            $table->string('jshshir');
            $table->date('pass_date');
            $table->string('address');
            $table->integer('sex');
            $table->date('job_date');
            $table->string('number');
            $table->string('comment');
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
        Schema::dropIfExists('demo_cadries');
    }
}
