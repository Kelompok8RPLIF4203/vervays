<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->integer('paymentMethodId');
            $table->text('step');
            $table->timestamps();

            $table->foreign('paymentMethodId')->references('id')
                ->on('payment_methods')
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
        Schema::table('steps', function(Blueprint $table){
            $table->dropForeign(['paymentMethodId']);
        });
        Schema::dropIfExists('steps');
    }
}
