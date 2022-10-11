<?php

use App\Models\ApiHttpLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiHttpLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_http_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('application_token_id')->nullable();
            $table->enum('type', [ApiHttpLog::OUTGOING, ApiHttpLog::INCOMING]);
            $table->ipAddress('ip')->nullable();
            $table->enum('http_method', ApiHttpLog::$httpMethods);
            $table->text('endpoint');
            $table->longText('request')->nullable();
            $table->longText('response')->nullable();
            $table->unsignedInteger('response_code');
            $table->unsignedInteger('response_time');
            $table->timestamp('expires_at');
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
//        Schema::dropIfExists('api_http_logs');
    }
}
