<?php

namespace Database\Factories;

use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketPriorityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicketPriority::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order'       => $this->faker->unique()->numberBetween(4, 100),
            'name'        => ucfirst($this->faker->unique()->word),
            'description' => ucfirst($this->faker->words(10, true)),
        ];
    }
}
