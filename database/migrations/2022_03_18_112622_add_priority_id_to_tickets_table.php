<?php

use App\Models\Ticket;
use App\Models\TicketPriority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityIdToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('priority_id')->after('id');
        });

        $defaultPriority = TicketPriority::create([
            'order'       => 3,
            'name'        => __('Default Category'),
            'description' => 'This is a dummy description of Default Category',
        ]);

        Ticket::all()->each->update([
            'priority_id' => $defaultPriority->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('priority_id');
        });
    }
}
