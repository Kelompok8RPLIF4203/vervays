<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('paymentId');
            $table->integer('userId');
            $table->integer('year');
            $table->integer('month');
            $table->integer('date');
            $table->integer('hour');
            $table->integer('minute');
            $table->enum('status',['pending', 'success', 'failed'])
                ->default('pending');
            $table->timestamps();

            $table->foreign('paymentId')->references('id')
                ->on('payments')
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
        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign(['paymentId']);
        });
        Schema::dropIfExists('orders');
    }
}
