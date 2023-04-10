<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingoing_mails', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('tgl_surat');
            $table->string('pengirim');
            $table->string('lampiran');
            $table->string('perihal');
            $table->foreignId('document_id')->nullable()->index();
            $table->string('arsip')->nullable();
            $table->string('tgl_terima');
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
        Schema::dropIfExists('ingoing_mails');
    }
};
