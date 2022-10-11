<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition($role = User::ROLE_ADMIN)
    {
        return [
            'synega_id'        => $this->faker->unique()->numberBetween(100, 999),
            'first_name'       => $this->faker->firstName,
            'last_name'        => $this->faker->lastName,
            'default_username' => $this->faker->unique()->userName,
            'email'            => $this->faker->unique()->safeEmail,
            'phone_number'     => $this->faker->unique()->numerify('+47##########'),
            'password'         => Hash::make('password'),
            'role'             => $role,
        ];
    }
}
