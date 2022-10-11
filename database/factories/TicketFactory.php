<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Country;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'priority_id'  => TicketPriority::inRandomOrder()->first()->id,
            'user_id'      => User::inRandomOrder()->first()->id,
            'requester_id' => User::inRandomOrder()->first()->id,
            'category_id'  => Category::inRandomOrder()->first()->id,
            'service_id'   => Service::inRandomOrder()->first()->id,
            'country_id'   => Country::inRandomOrder()->first()->id,
            'title'        => ucfirst($this->faker->words(3, true)),
            'due_at'       => $this->faker->dateTime(),
            'status'       => Ticket::STATUS_OPEN,
            'x_data'       => [
                'comment_user_id' => User::inRandomOrder()->first()->id,
                'comment'         => ucfirst($this->faker->words(30, true)),
            ],
        ];
    }
}
