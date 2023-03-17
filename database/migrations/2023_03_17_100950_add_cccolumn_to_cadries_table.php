<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCccolumnToCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->date('pass_date1')->nullable();
            $table->date('pass_date2')->nullable();
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
            $table->dropColumn("pass_date1");
            $table->dropColumn("pass_date2");
        });
    }
}
