<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDuoIdAndOneloginIdFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Column dropping should be done separately as sqlite which is used in tests does not support multiple column dropping.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('duo_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('onelogin_id');
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
            $table->string('duo_id')->unique()->nullable()->after('synega_id');
            $table->unsignedBigInteger('onelogin_id')->unique()->nullable()->after('synega_id');
        });
    }
}
