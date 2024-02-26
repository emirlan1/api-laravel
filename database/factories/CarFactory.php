<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'model' => $this->faker->randomElement(['Mazda', 'Toyota', 'BMW', 'Mercedes', 'Ferrari', 'Aston Martin', 'Audi', 'Volvo']),
            'year' => $this->faker->year
        ];
    }
}
