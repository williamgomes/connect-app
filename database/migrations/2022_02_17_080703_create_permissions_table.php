<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', [
                Permission::TYPE_FAQ,
                Permission::TYPE_ISSUES,
                Permission::TYPE_TICKETS,
                Permission::TYPE_IT_INFRASTRUCTURE,
                Permission::TYPE_BLOG,
                Permission::TYPE_API_DOCS,
            ]);
            $table->text('description');
            $table->timestamps();
        });

        foreach (Permission::$types as $key => $type) {
            Permission::create([
                'name'        => $type,
                'type'        => $key,
                'description' => 'Permission to manage with ' . $type,
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
        Schema::dropIfExists('permissions');
    }
}
