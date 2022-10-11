<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\IpAddress;
use App\Models\Network;
use Illuminate\Database\Eloquent\Factories\Factory;

class IpAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IpAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'network_id'   => Network::inRandomOrder()->first()->id,
            'inventory_id' => Inventory::inRandomOrder()->first()->id,
            'primary'      => false,
            'address'      => $this->faker->unique()->ipv4,
            'description'  => ucfirst($this->faker->words(10, true)),
        ];
    }
}
