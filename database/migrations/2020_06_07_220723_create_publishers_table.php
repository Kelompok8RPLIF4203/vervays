<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('userId');
            $table->integer('profilePhotoId');
            $table->string('name');
            $table->text('description');
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('userId')->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('profilePhotoId')->references('id')
                ->on('profile_photos')
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
        Schema::table('publishers', function(Blueprint $table){
            $table->dropForeign(['userId']);
            $table->dropForeign(['profilePhotoId']);
        });
        Schema::dropIfExists('publishers');
    }
}
