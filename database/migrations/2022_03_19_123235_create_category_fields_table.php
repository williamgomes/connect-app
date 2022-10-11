<?php

use App\Models\CategoryField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->enum('type', [
                CategoryField::TYPE_ATTACHMENT,
                CategoryField::TYPE_INPUT,
                CategoryField::TYPE_TEXT,
                CategoryField::TYPE_NUMBER,
                CategoryField::TYPE_DROPDOWN,
                CategoryField::TYPE_MULTIPLE,
            ]);
            $table->string('slug');
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->text('options')->nullable();
            $table->mediumText('default_value')->nullable();
            $table->boolean('required');
            $table->float('min')->nullable();
            $table->float('max')->nullable();
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
        Schema::dropIfExists('category_fields');
    }
}
