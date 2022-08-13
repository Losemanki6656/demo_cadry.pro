<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForeginToCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->BigInteger('railway_id')->unsigned()->change();
            $table->BigInteger('organization_id')->unsigned()->change();
            $table->BigInteger('department_id')->unsigned()->change();
            $table->BigInteger('birth_region_id')->unsigned()->change();
            $table->BigInteger('birth_city_id')->unsigned()->change();
            $table->BigInteger('pass_region_id')->unsigned()->change();
            $table->BigInteger('pass_city_id')->unsigned()->change();
            $table->BigInteger('address_region_id')->unsigned()->change();  
            $table->BigInteger('address_city_id')->unsigned()->change();  
            $table->BigInteger('education_id')->unsigned()->change();  
            $table->BigInteger('staff_id')->unsigned()->change();  
            $table->BigInteger('nationality_id')->unsigned()->change();  
            $table->BigInteger('party_id')->unsigned()->change();  
            $table->BigInteger('academictitle_id')->unsigned()->change(); 
            $table->BigInteger('academicdegree_id')->unsigned()->change();  
            $table->BigInteger('worklevel_id')->unsigned()->change();  
            $table->index('railway_id');
            $table->index('organization_id');
            $table->index('department_id');
            $table->index('birth_region_id');
            $table->index('birth_city_id');
            $table->index('pass_region_id');
            $table->index('pass_city_id');
            $table->index('address_region_id');  
            $table->index('address_city_id');  
            $table->index('education_id');  
            $table->index('staff_id');  
            $table->index('nationality_id');  
            $table->index('party_id');  
            $table->index('academictitle_id'); 
            $table->index('academicdegree_id');  
            $table->index('worklevel_id');  
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('birth_region_id')->references('id')->on('regions');
            $table->foreign('birth_city_id')->references('id')->on('cities');
            $table->foreign('pass_region_id')->references('id')->on('regions');
            $table->foreign('pass_city_id')->references('id')->on('cities');
            $table->foreign('address_region_id')->references('id')->on('regions');
            $table->foreign('address_city_id')->references('id')->on('cities');
            $table->foreign('education_id')->references('id')->on('education');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->foreign('party_id')->references('id')->on('parties');
            $table->foreign('academictitle_id')->references('id')->on('academic_titles');
            $table->foreign('academicdegree_id')->references('id')->on('academic_degrees');
            $table->foreign('worklevel_id')->references('id')->on('work_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadries', function (Blueprint $table) {
            //
        });
    }
}
