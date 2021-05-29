<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAllotmentIdColumnToFlashMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flash_messages', function (Blueprint $table) {
            $table->integer('allotmentId');
            $table->foreign('allotmentId')
                    ->references('id')
                    ->on('flash_message_allotments')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flash_messages', function (Blueprint $table) {
            DB::statement('ALTER TABLE flash_messages DROP FOREIGN KEY flash_messages_allotmentid_foreign');
            $table->dropColumn('allotmentId');
        });
    }
}
