<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameApplicationTablesToApiApplicationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update `applications` table
        Schema::rename('applications', 'api_applications');
        // Update `application_tokens` table
        Schema::rename('application_tokens', 'api_application_tokens');

        Schema::table('api_application_tokens', function (Blueprint $table) {
            $table->renameColumn('application_id', 'api_application_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_application_tokens', function (Blueprint $table) {
            $table->renameColumn('api_application_id', 'application_id');
        });

        // Revert `api_applications` table renaming
        Schema::rename('api_applications', 'applications');
        // Revert `api_application_tokens` table renaming
        Schema::rename('api_application_tokens', 'application_tokens');
    }
}
