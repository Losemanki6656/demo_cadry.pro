<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('org_send_id');
            $table->integer('dep_send_id');
            $table->integer('org_rec_id');
            $table->integer('dep_rec_id');
            $table->integer('send_id');
            $table->integer('recipient_id');
            $table->boolean('select_date');
            $table->text('task_text');
            $table->date('term');
            $table->boolean('rec_status');
            $table->boolean('task_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_tasks');
    }
}
