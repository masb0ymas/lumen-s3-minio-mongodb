<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvolvedUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('involved_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('unit_tujuan_id');
            $table->unsignedInteger('pegawai_id');
            $table->string('jenis_alur');
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
        Schema::dropIfExists('involved_unit');
    }
}
