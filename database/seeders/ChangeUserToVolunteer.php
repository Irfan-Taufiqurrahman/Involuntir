<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ChangeUserToVolunteer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $volunteers = fopen(asset("volunteers.txt"), "r") or die("Unable to open file!");
        $i = 1;
        while(!feof($volunteers)) {
            $user = User::where("email", str_replace("\n", "", fgets($volunteers)))->first();
            if($user) {
//                $user->update([
//                    'status_akun'  => 'Verified',
//                    'role'         => 'Volunteer',
//                    'tipe'         => 'Volunteer'
//                ]);
//                dump($user->email);
            }
        }
        fclose($volunteers);
    }
}
