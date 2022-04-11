<?php

namespace Database\Seeders;

use App\Models\Frequency;
use Illuminate\Database\Seeder;

class FrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkH = Frequency::where('name', 'Hour')->first();
        if ($checkH === null) {
            Frequency::create([
                'name' => 'Hour']);
        }
        $checkD = Frequency::where('name', 'Day')->first();
        if ($checkD === null) {
            Frequency::create([
                'name' => 'Day']);
        }
        $checkW = Frequency::where('name', 'Week')->first();
        if ($checkW === null) {
            Frequency::create([
                'name' => 'Week']);
        }
        $checkM = Frequency::where('name', 'Month')->first();
        if ($checkM === null) {
            Frequency::create([
                'name' => 'Month']);
        }
        $checkY = Frequency::where('name', 'Year')->first();
        if ($checkY === null) {
            Frequency::create([
                'name' => 'Year']);
        }
    }
}
