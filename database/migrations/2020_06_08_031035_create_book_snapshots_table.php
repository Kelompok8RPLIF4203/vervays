<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_snapshots', function (Blueprint $table) {
            $table->integer('bookId');
            $table->integer('orderId');
            $table->bigInteger('price');
            $table->timestamps();

            $table->foreign('bookId')->references('id')
                ->on('books')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('orderId')->references('id')
                ->on('orders')
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
        Schema::table('book_snapshots', function(Blueprint $table){
            $table->dropForeign(['bookId']);
            $table->dropForeign(['orderId']);
        });
        Schema::dropIfExists('book_snapshots');
    }
}
