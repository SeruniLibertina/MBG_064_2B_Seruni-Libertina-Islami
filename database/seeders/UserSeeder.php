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
public function run(): void {
    DB::table('users')->insert([
        ['name' => 'Gudang A', 'email' => 'gudang.a@gmail.com', 'password' => Hash::make('gudang.a'), 'role' => 'gudang'],
        ['name' => 'Dapur A', 'email' => 'dapur.a@gmail.com', 'password' => Hash::make('dapur.a'), 'role' => 'dapur'],
    ]);
}
}
