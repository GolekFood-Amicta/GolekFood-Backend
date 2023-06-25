<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSubsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'subscription' => 'Mingguan'
                // 'subscription' => fake()->randomElement(['-', 'Monthly', 'Yearly'])
                
            ],
            [
                'user_id' => 5,
                'subscription' => 'Mingguan'
                // 'subscription' => 
            ],
        ];

        foreach ($data as $d) {
            $d['subscription_start'] = Carbon::now()->format('Y-m-d H:i:s');
            $d['subscription_end'] = Carbon::now()->addDays(7)->format('Y-m-d H:i:s');
            DB::table('user_subs')->insert($d);
        }
    }
}
