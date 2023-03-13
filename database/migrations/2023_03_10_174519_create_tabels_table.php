<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->year('year')->deault(0);
            $table->integer('month')->deault(0);
            $table->json('days')->nullable();
            $table->integer('fact')->default(0);
            $table->integer('selosmenix_prostov')->default(0);
            $table->integer('ocherednoy_otpusk')->default(0);
            $table->integer('bolezn')->default(0);
            $table->integer('neyavki_razr')->default(0);
            $table->integer('razr_admin')->default(0);
            $table->integer('progul')->default(0);  
            $table->integer('vixod_prazd')->default(0);
            $table->integer('tekush_pros')->default(0);
            $table->integer('opazjanie')->default(0);
            $table->integer('vsevo')->default(0);
            $table->integer('sdelno')->default(0);
            $table->integer('svixurochniy')->default(0);
            $table->integer('nochnoy')->default(0);
            $table->integer('prazdnichniy')->default(0);
            $table->string('tabel_number')->nullable();
            $table->string('ustanovleniy')->default(0);
            $table->string('ekonomie')->default(0);
            $table->string('vid_oplate')->default(0);
            $table->string('sxema_rascheta')->default(0);
            $table->string('dop_priznak')->default(0);
            $table->string('prosent_primi')->default(0);
            $table->integer('dni_fact')->default(0);
            $table->integer('chasi_fact')->default(0);
            $table->integer('fact_rabot')->default(0);
            $table->integer('vixod_priznich')->default(0);
            $table->foreign('cadry_id')->references('id')->on('cadries');
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
        Schema::dropIfExists('tabels');
    }
}
