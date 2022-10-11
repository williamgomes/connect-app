<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(array_flip(CategoryField::$types));

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'type'        => $type,
            'title'       => ucfirst($this->faker->words(3, true)),
            'options'     => in_array($type, [CategoryField::TYPE_DROPDOWN, CategoryField::TYPE_MULTIPLE]) ? explode(' ', $this->faker->unique()->words(3, true)) : null,
            'required'    => false,
        ];
    }
}
