<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('directory_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('onelogin_id')->nullable();
            $table->string('duo_id')->nullable();
            $table->string('username');
            $table->timestamps();
        });

        // Move DUO/OneLogin id's to DirectoryUser
        $users = User::active()->get();
        foreach ($users as $user) {
            DB::table('directory_user')->insert([
                'directory_id' => 1,
                'user_id'      => $user->id,
                'onelogin_id'  => $user->onelogin_id,
                'duo_id'       => $user->duo_id,
                'username'     => $user->username,
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
        Schema::dropIfExists('directory_user');
    }
}
