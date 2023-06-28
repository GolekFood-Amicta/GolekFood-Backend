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
                'subscription' => 'Mingguan',
                'status' => 'Active',
                'subscription_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'subscription_end' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s')
                
            ],
            [
                'user_id' => 5,
                'subscription' => 'Mingguan',
                'status' => 'Active',
                'subscription_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'subscription_end' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3,
                'subscription' => 'Bulanan',
                'status' => 'Inactive',
            ],
            [
                'user_id' => 2,
                'subscription' => 'Bulanan',
                'status' => 'Inactive',
            ],
        ];

        foreach ($data as $d) {
            $d['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('user_subs')->insert($d);
        }
    }
}
