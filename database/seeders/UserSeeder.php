<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use phpseclib3\Crypt\Random;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', -1);
        $data = [];
        $user = collect(User::all()->modelKeys());
        for ($i = 0; $i < 500000; $i++) {
            $data[] = [
                'name' => $user->random(),
                'email' => $user->unique(),
                'password' => bcrypt($user->random()),
                'gender' => rand(0, 1),
                'age' => rand(18, 60),
                'dob' => mt_rand(1262055681, 1262055681),
                'mobile' => mt_rand(1111111111, mt_getrandmax()),
                'address' => $user->random(),
                'city' => $user->random(),
                'pincode' => $user->random(),
                'state' => $user->random(),
            ];
        }
        $chunks = array_chunk($data, 10000);

        // foreach ($chunks as $chunk) {
        User::insert($chunks)->chunk(1000);
        // }
    }
}
