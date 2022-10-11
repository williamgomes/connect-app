<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIpColumnsFromInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Column dropping should be done separately as sqlite which is used in tests does not support multiple column dropping.
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('private_ip');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('public_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('private_ip')->nullable()->after('it_service_id');
            $table->string('public_ip')->nullable()->after('it_service_id');
        });
    }
}
