<?php

namespace Database\Factories;

use App\Models\ItService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => strtoupper($this->faker->unique()->bothify('??????')),
            'name'       => ucfirst($this->faker->unique()->words(3, true)),
        ];
    }
}
