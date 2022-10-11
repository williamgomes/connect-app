<?php

namespace Database\Factories;

use App\Models\ApiApplication;
use App\Models\ApiApplicationToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiApplicationTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApiApplicationToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'api_application_id' => ApiApplication::inRandomOrder()->first()->id,
            'created_by'         => User::inRandomOrder()->first()->id,
            'revoked_by'         => User::inRandomOrder()->first()->id,
            'identifier'         => strtoupper($this->faker->unique()->bothify('?????????????')),
            'api_token'          => Str::random(100),
            'last_used_at'       => $this->faker->dateTime(),
        ];
    }
}
