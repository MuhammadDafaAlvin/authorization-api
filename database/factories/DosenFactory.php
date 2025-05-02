<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'nidn' => $this->faker->unique()->numerify('##########'),
            'nama_dosen' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'program_studi' => 'Manajemen Informatika',
            'email' => $this->faker->unique()->safeEmail(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'status' => $this->faker->randomElement(['Dosen Tetap', 'Dosen Tidak Tetap']),
        ];
    }
}
