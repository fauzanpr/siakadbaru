<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai = [
            [
                'matakuliah_id' => 1,
                'mahasiswa_id' => 2,
                'nilai_angka' => 90,
                'nilai_huruf' => 'A'
            ],
            [
                'matakuliah_id' => 2,
                'mahasiswa_id' => 2,
                'nilai_angka' => 91,
                'nilai_huruf' => 'A'
            ],
            [
                'matakuliah_id' => 3,
                'mahasiswa_id' => 2,
                'nilai_angka' => 90,
                'nilai_huruf' => 'A'
            ],
            [
                'matakuliah_id' => 4,
                'mahasiswa_id' => 2,
                'nilai_angka' => 90,
                'nilai_huruf' => 'A'
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($nilai);
    }
}
