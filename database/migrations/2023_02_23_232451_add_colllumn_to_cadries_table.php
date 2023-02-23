<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColllumnToCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->string('gmail')->nullable();
            $table->boolean('inostrans')->default(false);
            $table->date('date_inostrans')->nullable();
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
            $table->dropColumn("gmail");
            $table->dropColumn("inostrans");
            $table->dropColumn("date_inostrans");
        });
    }
}
