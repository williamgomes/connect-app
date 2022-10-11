<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApplicationUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application_id' => Application::inRandomOrder()->first()->id,
            'user_id'        => User::inRandomOrder()->first()->id,
            'provisioned'    => false,
            'direct'         => true,
            'active'         => true,
            'password'       => Str::random(32),
        ];
    }
}
