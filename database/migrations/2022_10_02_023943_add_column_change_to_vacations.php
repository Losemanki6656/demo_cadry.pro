<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnChangeToVacations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->string('command_number')->nullable();
            $table->date('period1')->nullable();
            $table->date('period2')->nullable();
            $table->integer('alldays')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->dropColumn("command_number");
            $table->dropColumn("period1");
            $table->dropColumn("period2");
            $table->dropColumn("alldays");
        });
    }
}
