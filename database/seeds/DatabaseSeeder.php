<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(AqiCategoriesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(UnitValuesTableSeeder::class);
    }
}
