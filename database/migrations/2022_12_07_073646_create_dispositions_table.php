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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_masuk_id')->nullable();
            $table->foreign('surat_masuk_id')->references('id')
                ->on('ingoing_mails')
                ->onDelete('cascade');
            $table->unsignedBigInteger('surat_keluar_id')->nullable();
            $table->foreign('surat_keluar_id')->references('id')
                ->on('outgoing_mails')
                ->onDelete('cascade');
            $table->enum('status', ['Belum Ada Balasan', 'Diproses', 'SELESAI'])->default('Belum Ada Balasan');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('dispositions');
    }
};
