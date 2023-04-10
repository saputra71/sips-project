<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_ingoing_mails', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('tgl_surat');
            $table->string('pengirim');
            $table->string('lampiran');
            $table->string('perihal');
            $table->foreignId('document_id')->nullable()->index();
            $table->string('arsip')->nullable();
            $table->string('tgl_terima');
            $table->string('deleted_at');
        });

        DB::unprepared('
        CREATE TRIGGER tr_ingoing_mails_delete
        AFTER DELETE ON ingoing_mails
        FOR EACH ROW
        BEGIN
            INSERT INTO deleted_ingoing_mails (nomor_surat, tgl_surat, pengirim, lampiran, perihal, document_id, arsip, tgl_terima, deleted_at)
            VALUES (OLD.nomor_surat, OLD.tgl_surat, OLD.pengirim, OLD.lampiran, OLD.perihal, OLD.document_id, OLD.arsip, OLD.tgl_terima, NOW());
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_ingoing_mails');
    }
};
