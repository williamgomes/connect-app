<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdAndServiceIdAndCategoryIdInTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('requester_id');
            $table->unsignedBigInteger('service_id')->after('requester_id');
            $table->unsignedBigInteger('country_id')->after('requester_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('service_id');
            $table->dropColumn('country_id');
        });
    }
}
