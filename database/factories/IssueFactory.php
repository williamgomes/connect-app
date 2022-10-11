<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Issue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id'   => User::inRandomOrder()->first()->id,
            'title'       => ucfirst($this->faker->unique()->words(3, true)),
            'key'         => strtoupper($this->faker->unique()->bothify('???????????')),
            'type'        => array_keys(Issue::$types)[$this->faker->numberBetween(0, 1)],
            'status'      => array_keys(Issue::$statuses)[$this->faker->numberBetween(0, 5)],
            'description' => ucfirst($this->faker->unique()->words(3, true)),
        ];
    }
}
