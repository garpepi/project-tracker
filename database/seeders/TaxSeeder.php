<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check1 = Tax::where('name', 'PPN')->first();
        if ($check1 === null) {
            Tax::create([
                'name' => 'PPN',
            ]);
        }
        $check2 = Tax::where('name', 'PPH 22')->first();
        if ($check2 === null) {
            Tax::create([
                'name' => 'PPH 22',
            ]);
        }
        $check3 = Tax::where('name', 'PPH 23')->first();
        if ($check3 === null) {
            Tax::create([
                'name' => 'PPH 23',
            ]);
        }
        $check4 = Tax::where('name', 'Withholding Tax')->first();
        if ($check4 === null) {
            Tax::create([
                'name' => 'Withholding Tax',
            ]);
        }
    }
}
