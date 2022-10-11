<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Directory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'directory_id'    => Directory::inRandomOrder()->first()->id,
            'name'            => ucfirst($this->faker->unique()->words(3, true)),
            'onelogin_app_id' => $this->faker->unique()->numberBetween(0, 255),
            'sso'             => false,
            'provisioning'    => false,
        ];
    }
}
