<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthDayAndPhoneNumberAndGenderToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthDay')->after('password')->nullable()->default(null);
            $table->string('phoneNumber')->after('birthDay')->nullable()->default(null);
            $table->enum('gender', ["male", "female"])->after('phoneNumber')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthDay');
            $table->dropColumn('phoneNumber');
            $table->dropColumn('gender');
        });
    }
}
