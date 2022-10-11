<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('company');
            $table->enum('type', [\App\Models\Inventory::TYPE_HARDWARE, \App\Models\Inventory::TYPE_SOFTWARE]);
            $table->enum('status', [\App\Models\Inventory::STATUS_PRODUCTION, \App\Models\Inventory::STATUS_DEVELOPMENT, \App\Models\Inventory::STATUS_STAGING]);
            $table->unsignedBigInteger('datacenter_id');
            $table->unsignedBigInteger('it_service_id');
            $table->string('public_ip')->nullable();
            $table->string('private_ip')->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
