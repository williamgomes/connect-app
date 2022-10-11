<?php

namespace Database\Factories;

use App\Models\Datacenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatacenterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Datacenter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => ucfirst($this->faker->unique()->words(3, true)),
            'country'     => strtoupper($this->faker->unique()->lexify('??')),
            'location'    => strtoupper($this->faker->unique()->lexify('???')),
            'location_id' => $this->faker->unique()->numberBetween(1, 100000),
        ];
    }
}
