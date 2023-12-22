<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Make sure to import Str class

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'socialite_id' => null,
            'socialite_name' => null,
            'name' => 'John Doe',
            'role' => 'User',
            'tipe' => 'Individu',
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'status_akun' => 'Verified',
            'no_telp' => '123456789',
            'usia' => '25',
            'jenis_kelamin' => 'Male',
            'alamat' => '123 Main Street',
            'provinsi' => 1,  // Replace with the actual province ID
            'kabupaten' => 1, // Replace with the actual district ID
            'kecamatan' => 1, // Replace with the actual sub-district ID
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1998-01-01',
            'pekerjaan' => 'Software Developer',
            'jenis_organisasi' => 'Community',
            'tanggal_berdiri' => '2020-01-01',
            'photo' => 'path/to/photo.jpg',
            'foto_ktp' => 'path/to/ktp.jpg',
            'bank' => 'BCA',
            'no_rek' => '1234567890',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
    }
}
