<?php

use App\Models\Faq;
use Illuminate\Database\Migrations\Migration;

class FixFilesPathsInFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faqs = Faq::where('content', 'like', '%ajax/files/%')->get();

        foreach ($faqs as $faq) {
            $fixedContent = str_replace('ajax/files/', 'files/', $faq->content);
            $faq->update([
                'content' => $fixedContent,
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
        //
    }
}
