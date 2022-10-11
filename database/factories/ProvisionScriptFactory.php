<?php

namespace Database\Factories;

use App\Models\ItService;
use App\Models\ProvisionScript;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvisionScriptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProvisionScript::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'it_service_id' => ItService::inRandomOrder()->first()->id,
            'title'         => ucfirst($this->faker->unique()->word),
            'content'       => ucfirst($this->faker->words(20, true)),
        ];
    }
}
