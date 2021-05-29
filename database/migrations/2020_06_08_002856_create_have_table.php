<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('have', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('userId');
            $table->integer('bookId');
            $table->integer('lastRead')->default(0);
            $table->timestamps();

            $table->foreign('userId')->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('bookId')->references('id')
                ->on('books')
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
        Schema::table('have', function(Blueprint $table){
            $table->dropForeign(['userId']);
            $table->dropForeign(['bookId']);
        });
        Schema::dropIfExists('have');
    }
}
