<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_pasien' => fake()->unique()->randomNumber(8),
            'nama' => fake()->name(),           
            'umur' => fake()->numberBetween(18,25),
            'jenis_kelamin' => fake()->randomElement(['laki-laki','perempuan']),
            'alamat' => fake()->address(),
            //
        ];
    }
}
