<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $randomNumber = rand(1, 30);
        return [
            'fname' => $this->faker->firstName(),
            'lname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$CFup8HZIxV52MiFEWZvqb.wHTbG0bH2JRekMKOJY/0Dr9pDvpRKhq', // 123456789
            'remember_token' => null,
            'photo' => 'public/custom-img/avtars/300-' . $randomNumber . '.jpg',
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
