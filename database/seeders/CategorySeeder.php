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
            ['name' => 'Penerimaan Mahasiswa Baru'],
            ['name' => 'Pembayaran Uang Kuliah'],
            ['name' => 'SIAKAD'],
            ['name' => 'E-Learning'],
            ['name' => 'Perubahan Data Mahasiswa'],
        ]);
    }
}
