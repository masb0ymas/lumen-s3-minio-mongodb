<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('organisasi_id');
            $table->string('kode_organisasi');
            $table->string('nama_jabatan');
            $table->integer('eselon');
            $table->string('kode_induk_organisasi');
            $table->string('kode_surat');
            $table->string('eselon_2');
            $table->string('eselon_3');
            $table->boolean('is_aktif');
            $table->string('no_sk');
            $table->string('nama_tim');
            $table->string('alamat');
            $table->string('nama_pejabat');
            $table->string('kop_surat');
            $table->boolean('allow_to_send');
            $table->unsignedInteger('unit_created');
            $table->unsignedInteger('user_created');
            $table->unsignedInteger('user_updated');
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
        Schema::dropIfExists('tim');
    }
}
