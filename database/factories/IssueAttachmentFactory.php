<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\IssueAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class IssueAttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IssueAttachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileName = Str::random(32) . '.docx';
        UploadedFile::fake()->create($fileName, 500, 'csv')->storeAs('issues/attachments/', $fileName);

        return [
            'issue_id'          => Issue::inRandomOrder()->first()->id,
            'filename'          => '/issues/attachments/' . $fileName,
            'original_filename' => ucfirst($this->faker->word),
        ];
    }
}
