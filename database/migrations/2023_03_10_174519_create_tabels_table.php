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
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_id')->unsigned()->index()->nullable();
            $table->bigInteger('send_user_id')->unsigned()->index()->nullable();
            $table->bigInteger('cadry_user_id')->unsigned()->index()->nullable();
            $table->bigInteger('bux_user_id')->unsigned()->index()->nullable();
            $table->year('year')->deault(0);
            $table->integer('month')->deault(0);
            $table->json('days')->nullable();
            $table->integer('fact')->default(0);
            $table->integer('selosmenix_prostov')->default(0);
            $table->integer('ocherednoy_otpusk')->default(0);
            $table->integer('otsusk_s_rodam')->default(0);
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
            $table->string('ustanovleniy')->nullable();
            $table->string('ekonomie')->nullable();
            $table->string('vid_oplate')->nullable();
            $table->string('sxema_rascheta')->nullable();
            $table->string('sintecheskiy')->nullable();
            $table->string('statya_rasxoda')->nullable();
            $table->string('dop_priznak')->nullable();
            $table->string('kod_primi')->nullable();
            $table->string('prosent_iz_primi')->nullable();
            $table->string('prosent_primi_iz')->nullable();
            $table->integer('dni_fact')->default(0);
            $table->integer('chasi_fact')->default(0);
            $table->integer('fact_rabot')->default(0);
            $table->integer('vixod_priznich')->default(0);
            $table->boolean('status_cadry')->default(false);
            $table->boolean('status_bux')->default(false);
            $table->foreign('cadry_id')->references('id')->on('cadries');
            $table->foreign('send_user_id')->references('id')->on('users');
            $table->foreign('cadry_user_id')->references('id')->on('users');
            $table->foreign('bux_user_id')->references('id')->on('users');
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
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
