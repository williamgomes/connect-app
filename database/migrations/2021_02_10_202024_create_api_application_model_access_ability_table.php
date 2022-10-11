<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiApplicationModelAccessAbilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_application_model_access_ability', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('api_application_id');
            $table->unsignedInteger('model_access_ability_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_application_model_access_ability');
    }
}
