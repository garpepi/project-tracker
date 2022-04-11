<?php

namespace Database\Seeders;

use App\Models\Email_configuration;
use Illuminate\Database\Seeder;

class EmailConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkDay = Email_configuration::where('id', 5)->first();
        if ($checkDay === null) {
            Email_configuration::create([
                'id' => 5,
                'frequency_id' => 2,
                'duration' => 8,
                'created_by' => 1,
            ]);
        }
        $checkMonth = Email_configuration::where('id', 7)->first();
        if ($checkMonth === null) {
            Email_configuration::create([
                'id' => 7,
                'frequency_id' => 4,
                'duration' => 15,
                'created_by' => 1,
            ]);
        }
        $checkWeek = Email_configuration::where('id', 8)->first();
        if ($checkWeek === null) {
            Email_configuration::create([
                'id' => 8,
                'frequency_id' => 3,
                'duration' => 2,
                'created_by' => 1,
            ]);
        }
    }
}
