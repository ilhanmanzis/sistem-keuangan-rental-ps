<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => 1,
            'name' => 'Janggar Fals',
            'logo' => 'profile.png',
            'alamat' => 'jl. java script, php artisan serve, npm install',
            'no_telpon' => '08867567567',
            'minimal' => 5,
            'bonus' => 2
        ];
    }
}
