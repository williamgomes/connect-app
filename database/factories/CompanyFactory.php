<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Models\Directory;
use App\Models\Service;
use App\Models\TmsInstance;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'directory_id'    => Directory::inRandomOrder()->first()->id,
            'country_id'      => Country::inRandomOrder()->first()->id,
            'service_id'      => Service::inRandomOrder()->first()->id,
            'tms_instance_id' => TmsInstance::inRandomOrder()->first()->id,
            'name'            => ucfirst($this->faker->unique()->word),
        ];
    }
}
