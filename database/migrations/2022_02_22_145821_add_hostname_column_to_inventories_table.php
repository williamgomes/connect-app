<?php

use App\Models\Inventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHostnameColumnToInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('hostname')->after('identifier');
        });

        $inventories = Inventory::all();
        foreach ($inventories as $inventory) {
            $identifier = $inventory->identifier;
            $identifierArray = explode('-', $identifier);

            $inventory->update([
                'hostname' => strtolower(end($identifierArray)),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('hostname');
        });
    }
}
