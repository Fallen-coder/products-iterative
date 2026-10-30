<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Piens',
            'Siers',
            'Jogurts',
            'Maize',
            'Sula',
            'Ūdens',
            'Šokolāde',
            'Kafija',
            'Tēja',
            'Cepumi',
            'Rīsi',
            'Makaroni',
            'Konservi',
            'Medus',
            'Sviests',
        ];

        $brands = [
            'Premium',
            'Classic',
            'Bio',
            'Fresh',
            'Natural',
            'Eco',
            'Deluxe',
            'Family',
        ];

        $category = fake()->randomElement($categories);
        $brand = fake()->randomElement($brands);

        return [
            'name' => $brand . ' ' . $category,

            'quantity' => fake()->numberBetween(1, 500),

             'price' => fake()->randomFloat(2, 0.50, 100),
        
            'description' => fake()->sentence(12),

            'expiration_date' => fake()->dateTimeBetween(
                'now',
                '+2 years'
            )->format('Y-m-d'),

            'status' => fake()->randomElement([
                'active',
                'inactive',
                'expired',
            ]),
        ];
    }
}