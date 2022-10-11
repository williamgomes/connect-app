<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::inRandomOrder()->first()->id,
            'read'       => false,
            'message_id' => Str::random(30),
            'from_name'  => ucfirst($this->faker->unique()->words(3, true)),
            'from'       => $this->faker->unique()->safeEmail,
            'to'         => $this->faker->unique()->safeEmail,
            'subject'    => ucfirst($this->faker->unique()->words(3, true)),
            'body'       => ucfirst($this->faker->unique()->words(30, true)),
        ];
    }
}
