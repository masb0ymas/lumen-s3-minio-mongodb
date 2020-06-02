<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('organisasi_id');
            $table->string('kode_organisasi');
            $table->string('nama_organisasi');
            $table->integer('eselon');
            $table->string('kode_induk_organisasi');
            $table->string('kode_surat');
            $table->string('nama_eselon_2');
            $table->string('nama_eselon_3');
            $table->string('nama_eselon_1');
            $table->string('alamat');
            $table->string('nama_jabatan');
            $table->string('nama_pejabat');
            $table->string('nip_pejabat');
            $table->boolean('allow_to_send');
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
        Schema::dropIfExists('unit');
    }
}
