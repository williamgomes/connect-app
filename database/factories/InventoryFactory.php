<?php

namespace Database\Factories;

use App\Models\Datacenter;
use App\Models\Inventory;
use App\Models\ItService;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier'    => $this->faker->unique()->lexify('???-??-???????-??-????'),
            'type'          => $this->faker->randomElement([Inventory::TYPE_SOFTWARE, Inventory::TYPE_HARDWARE]),
            'status'        => $this->faker->randomElement([Inventory::STATUS_PRODUCTION, Inventory::STATUS_DEVELOPMENT, Inventory::STATUS_STAGING]),
            'datacenter_id' => Datacenter::inRandomOrder()->first()->id,
            'it_service_id' => ItService::inRandomOrder()->first()->id,
        ];
    }
}
