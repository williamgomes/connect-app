<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderColumnToFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faq', function (Blueprint $table) {
            $table->unsignedInteger('order')->after('active');
        });
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->unsignedInteger('order')->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faq', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('faq_categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
