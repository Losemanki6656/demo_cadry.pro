<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrgSortToCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->integer('org_order')->default(250);
            $table->integer('dep_order')->default(80);
            $table->integer('order')->nullable();
            $table->integer('status_dec')->nullable();
            $table->integer('status_med')->nullable();
            $table->integer('status_bs')->nullable();
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
            $table->dropColumn("org_order");
            $table->dropColumn("dep_order");
            $table->dropColumn("order");
            $table->dropColumn("status_dec");
            $table->dropColumn("status_med");
            $table->dropColumn("status_bs");
        });
    }
}
