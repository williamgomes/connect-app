<?php

namespace Database\Factories;

use App\Models\Network;
use Illuminate\Database\Eloquent\Factories\Factory;

class NetworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Network::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => ucfirst($this->faker->unique()->words(3, true)),
            'ip_address' => $this->faker->ipv4,
            'cidr'       => $this->faker->numberBetween(24, 32),
            'vlan_id'    => $this->faker->numberBetween(0, 4095),
        ];
    }
}
