<?php

namespace Database\Factories;

use App\Models\Daftar;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarFactory extends Factory
{
    protected $model = Daftar::class;

    public function definition()
    {
        // Mengambil semua ID dari tabel pasien
        $idPasien =\App\Models\Pasien::pluck('id')->toArray();

        // Mengambil semua ID dari tabel poli
        //$availablePoliIds = Poli::pluck('id')->toArray();

        return [
            'pasien_id' => $this ->faker->randomElement($idPasien),
            'tanggal_daftar' => $this ->faker->date(),
            'poli' => $this->faker->randomElement(['Umum','Gigi','Kandungan', 'Anak']),
            'keluhan' => $this->faker->sentence(),
            'diagnosis' => $this->faker->sentence(),
            'tindakan' => $this->faker->sentence(),
        ];
    }
}
