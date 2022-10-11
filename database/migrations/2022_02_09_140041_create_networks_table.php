<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->unsignedTinyInteger('cidr');
            $table->unsignedSmallInteger('vlan_id');
            $table->string('gateway');
            $table->string('broadcast');
            $table->string('address_from');
            $table->string('address_to');
            $table->unsignedInteger('total_hosts');
            $table->unsignedInteger('usable_hosts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('networks');
    }
}
