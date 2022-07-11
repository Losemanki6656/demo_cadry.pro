<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_files', function (Blueprint $table) {
            $table->id();
            $table->integer('send_id');
            $table->integer('recipient_id');
            $table->string('topic');
            $table->string('file_path');
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
        Schema::dropIfExists('send_files');
    }
}
