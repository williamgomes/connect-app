<?php

namespace Database\Factories;

use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class TicketCommentAttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicketCommentAttachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileName = Str::random(32) . '.docx';
        $file = UploadedFile::fake()->create($fileName, 500, 'csv')->storeAs('tickets/attachments/', $fileName);

        return [
            'ticket_comment_id' => TicketComment::inRandomOrder()->first()->id,
            'filename'          => 'tickets/attachments/' . $fileName,
            'original_filename' => ucfirst($this->faker->word),
        ];
    }
}
