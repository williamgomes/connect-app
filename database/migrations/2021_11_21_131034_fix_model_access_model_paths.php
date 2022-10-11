<?php

use App\Models\ModelAccess;
use Illuminate\Database\Migrations\Migration;

class FixModelAccessModelPaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $models = [
            'Ticket',
            'User',
        ];

        foreach ($models as $model) {
            $modelAccess = ModelAccess::where('model', 'App\Repositories\\' . $model . '\\' . $model)->first();

            if ($modelAccess) {
                $modelAccess->update([
                    'model' => 'App\Models\\' . $model,
                ]);
            }
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
