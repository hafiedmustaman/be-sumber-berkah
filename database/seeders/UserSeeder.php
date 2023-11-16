<?php

namespace Database\Seeders;

use App\Models\User; // untuk melakukan insert data ke dalam table users.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin Sumber Berkah Store',
            'email'     => 'hafiedmustaman@gmail.com',
            'password'  => bcrypt('password')
            // helper bcrypt ini digunakan untuk melakukan hash terhadap password yang ingin di simpan ke dalam database.
        ]);
    }
}
