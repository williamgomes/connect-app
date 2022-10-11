<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'  => User::inRandomOrder()->first()->id,
            'status'   => BlogPost::STATUS_VISIBLE,
            'category' => ucfirst($this->faker->words(3, true)),
            'title'    => ucfirst($this->faker->unique()->words(3, true)),
            'content'  => ucfirst($this->faker->words(20, true)),
        ];
    }
}
