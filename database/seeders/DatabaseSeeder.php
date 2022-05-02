<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
        ProgressStatusSeeder::class,
        TypeSeeder::class,
        FrequencySeeder::class,
        EmailConfigurationSeeder::class,
        TaxSeeder::class,
        SuplierSeeder::class,
        RoleSeeder::class,
        MenuHeaderSeeder::class,
        MenusSeeder::class,
        AccessmenuSeeder::class,
        ]);
    }
}
