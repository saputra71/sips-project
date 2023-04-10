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
        Schema::table('ingoing_mails', function (Blueprint $table) {
            DB::unprepared('
            CREATE PROCEDURE `count_ingoing_mails`()
            BEGIN
                SELECT COUNT(*) FROM `ingoing_mails`;
            END
        ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingoing_mails', function (Blueprint $table) {
            //
        });
    }
};
