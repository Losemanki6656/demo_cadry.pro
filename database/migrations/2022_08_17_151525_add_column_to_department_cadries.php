<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDepartmentCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_cadries', function (Blueprint $table) {
            $table->boolean('status_decret')->default(false);
            $table->date('staff_date')->nullable();
            $table->boolean('staff_status')->default(false);
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
            $table->dropColumn("status");
            $table->dropColumn("staff_date");
            $table->dropColumn("staff_status");
        });
    }
}
