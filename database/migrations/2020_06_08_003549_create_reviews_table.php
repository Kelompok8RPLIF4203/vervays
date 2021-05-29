<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->float('rating');
            $table->text('review');
            $table->integer('haveId');
            $table->timestamps();

            $table->foreign('haveId')->references('id')
                ->on('have')
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
        Schema::table('reviews', function(Blueprint $table){
            $table->dropForeign(['haveId']);
        });
        Schema::dropIfExists('reviews');
    }
}
