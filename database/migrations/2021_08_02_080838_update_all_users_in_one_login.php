<?php

use App\Jobs\HandleUserInOneLogin;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class UpdateAllUsersInOneLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (User::all() as $user) {
            HandleUserInOneLogin::dispatch($user);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
