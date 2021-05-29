<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeletedColumnToPublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `publishers` CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
        Schema::table('publishers', function (Blueprint $table) {
            $table->boolean('isDeleted')->after('year')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `publishers` CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL');
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropColumn('isDeleted');
        });
    }
}
