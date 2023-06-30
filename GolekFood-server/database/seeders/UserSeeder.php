<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // 'name',
        // 'email',
        // 'password',
        // 'address',
        // 'avatar'
        $data = [
            [
                'name' => 'Ade Febrian',
                'email' => 'ade@gmail.com',
                'password' => Hash::make('password'),
                'address'=> fake()->address(),
                'roles_id' => rand(1,2),
                // 'subscription' => fake()->randomElement(['-', 'Monthly', 'Yearly'])
                
            ],
            [
                'name' => 'Anas Hanif',
                'email' => 'anas@gmail.com',
                'password' => Hash::make('password'),
                'address'=> fake()->address(),
                'roles_id' => rand(1,2),
                // 'subscription' => fake()->randomElement(['-', 'Monthly', 'Yearly'])
            ],
            [
                'name' => 'Ken Diani',
                'email' => 'ken@gmail.com',
                'password' => Hash::make('password'),
                'address'=> fake()->address(),
                'roles_id' => rand(1,2),
                // 'subscription' => fake()->randomElement(['-', 'Monthly', 'Yearly'])
            ],
            [
                'name' => 'Zaky',
                'email' => 'Zaky@gmail.com',
                'password' => Hash::make('password'),
                'address'=> fake()->address(),
                'roles_id' => rand(1,2),
                // 'subscription' => fake()->randomElement(['-', 'Monthly', 'Yearly'])

            ],
            [
                'name' => 'Arifin',
                'email' => 'arifin@gmail.com',
                'password' => Hash::make('password'),
                'address'=> fake()->address(),
                'roles_id' => rand(1,2),
               
            ],
        ];

        foreach ($data as $d) {
            $d['avatar'] = 'default-profile.png';
            $d['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $d['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('users')->insert($d);
        }
    }
}
