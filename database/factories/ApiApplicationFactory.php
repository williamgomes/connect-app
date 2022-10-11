<?php

namespace Database\Factories;

use App\Models\ApiApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApiApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->word),
        ];
    }
}
