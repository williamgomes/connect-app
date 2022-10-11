<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => User::inRandomOrder()->first()->id,
            'uploaded_by' => User::inRandomOrder()->first()->id,
            'title'       => ucfirst($this->faker->unique()->words(3, true)),
            'filename'    => ucfirst($this->faker->unique()->words(3, true)),
        ];
    }
}
