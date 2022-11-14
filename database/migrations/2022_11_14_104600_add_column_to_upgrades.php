<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUpgrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('upgrades', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('comment')->nullable();
            $table->string('command_number')->nullable();
            $table->string('address_old')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upgrades', function (Blueprint $table) {
            $table->dropColumn("address");
            $table->dropColumn("comment");
            $table->dropColumn("command_number");
            $table->dropColumn("address_old");
        });
    }
}
