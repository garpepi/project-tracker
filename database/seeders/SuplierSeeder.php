<?php

namespace Database\Seeders;

use App\Models\Suplier;
use Illuminate\Database\Seeder;

class SuplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check1 = Suplier::where('name', 'Intel')->first();
        if ($check1 === null) {
            Suplier::create([
                'name' => 'Intel',
            ]);
        }
        $check2 = Suplier::where('name', 'AMD')->first();
        if ($check2 === null) {
            Suplier::create([
                'name' => 'AMD',
            ]);
        }
    }
}
