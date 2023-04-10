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
        DB::unprepared('
            CREATE FUNCTION count_outgoing_daily() RETURNS INT
            BEGIN
                DECLARE count_outgoing_daily INT;
                SELECT COUNT(*) INTO count_outgoing_daily FROM outgoing_mails WHERE DATE(created_at) = CURDATE();
                RETURN count_outgoing_daily;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('function');
    }
};
