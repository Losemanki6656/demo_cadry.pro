<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeColumnToIncentives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incentives', function (Blueprint $table) {
            $table->BigInteger('railway_id')->unsigned()->nullable();
            $table->BigInteger('organization_id')->unsigned()->nullable();
            $table->BigInteger('cadry_id')->unsigned()->change();  
            $table->index('railway_id');
            $table->index('organization_id');
            $table->index('cadry_id');
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('cadry_id')->references('id')->on('cadries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incentives', function (Blueprint $table) {
            $table->dropColumn("railway_id");
            $table->dropColumn("organization_id");
        });
    }
}
