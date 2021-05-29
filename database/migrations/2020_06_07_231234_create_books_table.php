<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title');
            $table->string('author');
            $table->integer('languageId');
            $table->integer('numberOfPage');
            $table->bigInteger('price');
            $table->bigInteger('discountPrice');
            $table->text('synopsis');
            $table->boolean('isDeleted')->default('0');
            $table->integer('ebookFileId');
            $table->integer('sampleEbookFileId');
            $table->integer('ebookCoverId');
            $table->boolean('isEditorChoice')->default('0');
            $table->timestamps();

            $table->foreign('languageId')->references('id')
                ->on('languages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ebookFileId')->references('id')
                ->on('ebook_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('sampleEbookFileId')->references('id')
                ->on('sample_ebook_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ebookCoverId')->references('id')
                ->on('ebook_covers')
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
        Schema::table('books', function(Blueprint $table){
            $table->dropForeign(['languageId']);
            $table->dropForeign(['ebookFileId']);
            $table->dropForeign(['sampleEbookFileId']);
            $table->dropForeign(['ebookCoverId']);
        });
        Schema::dropIfExists('books');
    }
}
