<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCooolumnToDepartmentCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_cadries', function (Blueprint $table) {
            $table->double('razryad')->default(0);
            $table->double('koef')->default(0);
            $table->double('min_sum')->default(0);
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
            $table->dropColumn("razryad");
            $table->dropColumn("koef");
            $table->dropColumn("min_sum");
        });
    }
}
