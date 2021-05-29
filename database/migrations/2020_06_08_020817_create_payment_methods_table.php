<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('paymentId');
            $table->string('name');
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
        Schema::table('payment_methods', function(Blueprint $table){
            $table->dropForeign(['paymentId']);
        });
        Schema::dropIfExists('payment_methods');
    }
}
