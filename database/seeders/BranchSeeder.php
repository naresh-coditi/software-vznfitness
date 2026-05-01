<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('branches')->insert([
            [
                'name' => 'Elite Gym And Spa',
                'location' => 'Sector 32 D, Chandigarh',
                'address' => 'SCO - 264, 265, 266, 267, 1st Floor, Sector-32 D, Chandigarh',
                'gst_no' => NULL,
                'phone' => NULL,
                'open_at' => NULL,
            ],
            [
                'name' => 'Elite Gym And Spa',
                'location' => 'Sector 34, Chandigarh',
                'address' => '4th Floor, Piccadily Square Mall, Sector 34A, Sector 34, Chandigarh, 160022',
                'gst_no' => NULL,
                'phone' => NULL,
                'open_at' => NULL,
            ]
        ]);
    }
}
