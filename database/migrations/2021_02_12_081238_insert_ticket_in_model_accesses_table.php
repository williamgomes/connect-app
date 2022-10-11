<?php

use App\Models\ModelAccess;
use App\Models\ModelAccessAbility;
use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;

class InsertTicketInModelAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ticketModelAccess = ModelAccess::create([
            'model'       => Ticket::class,
            'name'        => 'Ticket',
            'description' => 'Full control of all ticket abilities.',
        ]);

        $abilities = [
            [
                'ability'     => 'viewAny',
                'name'        => 'View any',
                'description' => 'View any ticket.',
            ],
            [
                'ability'     => 'create',
                'name'        => 'Create',
                'description' => 'Create a new ticket record.',
            ],
            [
                'ability'     => 'view',
                'name'        => 'View',
                'description' => 'View specific ticket record.',
            ],
            [
                'ability'     => 'update',
                'name'        => 'Update',
                'description' => 'Update specific ticket record.',
            ],
            [
                'ability'     => 'reply',
                'name'        => 'Reply',
                'description' => 'Reply to specific ticket record.',
            ],
            [
                'ability'     => 'markAsSolved',
                'name'        => 'Mark as solved',
                'description' => 'Mark specific ticket as solved.',
            ],
        ];

        foreach ($abilities as $abilityData) {
            ModelAccessAbility::create(array_merge($abilityData, ['model_access_id' => $ticketModelAccess->id]));
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
