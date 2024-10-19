<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineCentersMaximumLimitUpdatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = DB::table('vaccine_centers')->select("id")->get();
        foreach ($centers as $center) {
            $limit = rand(3, 13);
            DB::table('vaccine_centers')->where('id', $center->id)->update(['maximum_limit' => $limit]);
        }
    }
}
