<?php

namespace Database\Seeders;

use App\Models\Menu_header;
use Illuminate\Database\Seeder;

class MenuHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check1 = Menu_header::where('name', 'Operational')->first();
        if ($check1 === null) {
            Menu_header::create([
                'name' => 'Operational',
            ]);
        }
        $check1 = Menu_header::where('name', 'Configuration')->first();
        if ($check1 === null) {
            Menu_header::create([
                'name' => 'Configuration',
            ]);
        }
        $check1 = Menu_header::where('name', 'Monitoring')->first();
        if ($check1 === null) {
            Menu_header::create([
                'name' => 'Monitoring',
            ]);
        }
    }
}
