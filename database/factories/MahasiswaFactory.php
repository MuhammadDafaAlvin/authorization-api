<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['L', 'P']);
        $nama = $gender === 'L'
            ? $this->faker->firstNameMale() . ' ' . $this->faker->lastName()
            : $this->faker->firstNameFemale() . ' ' . $this->faker->lastName();

        return [
            'nim' => '20' . $this->faker->unique()->numerify('########'),
            'nama' => $nama,
            'jenis_kelamin' => $gender,
            'alamat' => $this->faker->address(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2004-12-31'),
            'program_studi' => $this->faker->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen Informatika'
            ]),
            'angkatan' => $this->faker->year('2023'),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
