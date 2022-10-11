<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FaqCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => FaqCategory::inRandomOrder()->first()->id ?? null,
            'name'        => ucfirst($this->faker->unique()->words(3, true)),
            'active'      => true,
            'order'       => $this->faker->unique()->numberBetween(4, 100),
        ];
    }
}
