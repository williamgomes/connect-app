<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => FaqCategory::inRandomOrder()->first()->id,
            'user_id'     => User::inRandomOrder()->first()->id,
            'title'       => ucfirst($this->faker->unique()->words(3, true)),
            'content'     => ucfirst($this->faker->unique()->words(30, true)),
            'active'      => true,
            'order'       => $this->faker->unique()->numberBetween(4, 100),
        ];
    }
}
