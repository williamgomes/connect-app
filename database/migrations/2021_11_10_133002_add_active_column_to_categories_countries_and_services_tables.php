<?php

use App\Models\Category;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveColumnToCategoriesCountriesAndServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('active')->default(Category::IS_ACTIVE)->after('id');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->boolean('active')->default(Country::IS_ACTIVE)->after('id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->boolean('active')->default(Service::IS_ACTIVE)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
