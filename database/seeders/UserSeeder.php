<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Directory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['role' => User::ROLE_ADMIN, 'amount' => 1],
            ['role' => User::ROLE_AGENT, 'amount' => 1],
            ['role' => User::ROLE_REPORTING, 'amount' => 3],
            ['role' => User::ROLE_DEVELOPER, 'amount' => 3],
            ['role' => User::ROLE_REGULAR, 'amount' => 3],
        ];

        foreach ($settings as $setting) {
            User::factory($setting['amount'])
                ->create([
                    'role' => $setting['role'],
                ])
                ->each(function ($user) {
                    $user->roles()->attach(Role::inRandomOrder()->first(), ['company_id' => Company::inRandomOrder()->first()->id]);
                    $user->directoryUsers()->create(['directory_id' => Directory::inRandomOrder()->first()->id, 'username' => Str::random(32)]);
                });
        }
    }
}
