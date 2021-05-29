<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('publisherId');
            $table->integer('bankId');
            $table->bigInteger('amount');
            $table->string('accountOwner');
            $table->enum('status',['pending', 'success', 'failed'])
                ->default('pending');
            $table->timestamps();

            $table->foreign('publisherId')->references('id')
                ->on('publishers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('bankId')->references('id')
                ->on('banks')
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
        Schema::table('cashouts', function(Blueprint $table){
            $table->dropForeign(['publisherId']);
            $table->dropForeign(['bankId']);
        });
        Schema::dropIfExists('cashouts');
    }
}
