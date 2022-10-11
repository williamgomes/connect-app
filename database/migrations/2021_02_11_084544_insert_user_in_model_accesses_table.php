<?php

use App\Models\ModelAccess;
use App\Models\ModelAccessAbility;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class InsertUserInModelAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $modelAccess = ModelAccess::create([
            'model'       => User::class,
            'name'        => 'User',
            'description' => 'Full control of all user abilities.',
        ]);

        $abilities = [
            [
                'ability'     => 'viewAny',
                'name'        => 'View any',
                'description' => 'View any user record.',
            ],
            [
                'ability'     => 'create',
                'name'        => 'Create',
                'description' => 'Create a new user record.',
            ],
            [
                'ability'     => 'view',
                'name'        => 'View',
                'description' => 'View specific user record.',
            ],
            [
                'ability'     => 'update',
                'name'        => 'Update',
                'description' => 'Update specific user record.',
            ],
        ];

        foreach ($abilities as $abilityData) {
            ModelAccessAbility::create(array_merge($abilityData, ['model_access_id' => $modelAccess->id]));
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
