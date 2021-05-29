<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTimeColoumnInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->dropColumn('month');
            $table->dropColumn('date');
            $table->dropColumn('hour');
            $table->dropColumn('minute');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('year');
            $table->integer('month');
            $table->integer('date');
            $table->integer('hour');
            $table->integer('minute');
        });
    }
}
