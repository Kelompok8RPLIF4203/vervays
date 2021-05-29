<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_messages', function (Blueprint $table) {
            $table->integer('userId');
            $table->string('message');
            $table->enum('type', ['success', 'info', 'warning', 'danger']);
            $table->foreign('userId')
                    ->references('id')
                    ->on('users')
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
        Schema::table('flash_messages', function(Blueprint $table){
            $table->dropForeign(['userId']);
        });
        Schema::dropIfExists('flash_messages');
    }
}
