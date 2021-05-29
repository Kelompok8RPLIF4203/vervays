<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->integer('userId');
            $table->integer('bookId');
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
        Schema::table('carts', function(Blueprint $table){
            $table->dropForeign(['userId']);
            $table->dropForeign(['bookId']);
        });
        Schema::dropIfExists('carts');
    }
}
