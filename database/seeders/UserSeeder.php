<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Data Gudang A diganti dengan Budi Santoso
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.gudang@mbg.id',
                'password' => Hash::make('gudang123'), 
                'role' => 'gudang',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            // Data Dapur A tetap ada
            [
                'name' => 'Dapur A',
                'email' => 'dapur.a@gmail.com',
                'password' => Hash::make('dapur.a'),
                'role' => 'dapur',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}