<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $increment = 10;
        $currentNumber = 10;
        $centers = array(
            "Dhanmondi",
            "Jatrabari",
            "Kamalapur Railstation",
            "Khilkhet",
            "Mirpur-10",
            "Mirpur-13",
            "Mouchak",
            "Muhammadpur",
            "Ramana",
            "Uttara",
        );
        for ($i = 0; $i < count($centers); $i++) {

            DB::table('vaccine_centers')->insert([
                'name' => $centers[$i],
                'sort' => $currentNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $currentNumber += $increment;
        }
    }
}
