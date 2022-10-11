<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\ReportFolder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'metabase_id' => $this->faker->numberBetween(1, 9999999999999),
            'folder_id'   => ReportFolder::inRandomOrder()->first()->id,
            'user_id'     => User::inRandomOrder()->first()->id,
            'title'       => ucfirst($this->faker->unique()->words(3, true)),
        ];
    }
}
