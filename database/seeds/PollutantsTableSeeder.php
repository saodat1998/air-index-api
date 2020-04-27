<?php

use Illuminate\Database\Seeder;

class PollutantsTableSeeder extends Seeder
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

        /* `air`.`pollutants` */
        $pollutants = array(
            array('id' => '1', 'unit_name'=> 'ppb', 'name' => 'Ozone (O3) (ppb)-8hr', 'calculation_period' => '8hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '2', 'unit_name'=> 'ppb', 'name' => 'Ozone (O3) (ppb)-1hr', 'calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '3', 'unit_name'=> 'ug/m3', 'name' => 'PM2.5 (μg/m3)-24hr', 'calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '4', 'unit_name'=> 'ug/m3', 'name' => 'PM10 (μg/m3)-24hr', 'calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '5', 'unit_name'=> 'ppm', 'name' => 'CO (ppm)-8hr', 'calculation_period' => '8hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '6', 'unit_name'=> 'ppb', 'name' => 'SO2 (ppb)-1hr', 'calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '7', 'unit_name'=> 'ppb', 'name' => 'SO2 (ppb)-24hr', 'calculation_period' => '24hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '8', 'unit_name'=> 'ppb', 'name' => 'NO2 (ppb)-1hr', 'calculation_period' => '1hr','formula' => NULL,'note' => NULL,'created_at' => NULL,'updated_at' => NULL)
        );

        DB::table('pollutants')->insert($pollutants);

    }
}
