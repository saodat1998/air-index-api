<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Database `air`
         */

        /* `air`.`units` */
        $units = array(
            array('id' => '1','name' => 'O3 (ppb)-8hr','calculation_period' => '8hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','name' => 'O3 (ppb)-1hr','calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','name' => 'PM2.5 (μg/m3)-24hr','calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '4','name' => 'PM10 (μg/m3)-24hr','calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '5','name' => 'CO (ppm)-8hr','calculation_period' => '8hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '6','name' => 'SO2 (ppb)-1hr','calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '7','name' => 'SO2 (ppb)-24hr','calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '8','name' => 'NO2 (ppb)-1hr','calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL)
        );

        DB::table('units')->insert($units);

    }
}
