<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCccolumnToDepartmentCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_cadries', function (Blueprint $table) {
            $table->bigInteger('work_status_id')->unsigned()->index()->nullable();
            $table->date('work_date1')->nullable();
            $table->date('work_date2')->nullable();
            $table->foreign('work_status_id')->references('id')->on('work_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_cadries', function (Blueprint $table) {
            Schema::dropIfExists('work_status_id');
            Schema::dropIfExists('work_date1');
            Schema::dropIfExists('work_date2');
        });
    }
}
