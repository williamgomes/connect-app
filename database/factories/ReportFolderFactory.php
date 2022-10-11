<?php

namespace Database\Factories;

use App\Models\ReportFolder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFolderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReportFolder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'name'    => ucfirst($this->faker->unique()->words(3, true)),
        ];
    }
}
