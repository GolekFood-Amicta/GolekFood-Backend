<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 5,
                'title' => 'Ini title coy',
                'body' => 'ini buat bodynya coy',
            ],
            [
                'user_id' => 5,
                'title' => 'Ini title coy',
                'body' => 'ini buat bodynya coy',
            ],
            
        ];

        foreach ($data as $d) {
            $d['image'] = 'default-image.png';
            $d['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $d['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('news')->insert($d);
        }
    }
}
