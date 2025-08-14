<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Penerimaan Mahasiswa Baru', 'slug' => 'pmb'],
            ['name' => 'Pembayaran Uang Kuliah', 'slug' => 'pembayaran-uang-kuliah'],
            ['name' => 'SIAKAD', 'slug' => 'siakad'],
            ['name' => 'E-Learning', 'slug' => 'lms'],
            ['name' => 'Perubahan Data Mahasiswa', 'slug' => 'pdm'],
        ]);
    }
}
