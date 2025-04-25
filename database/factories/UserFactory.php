<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ];
    }
}
