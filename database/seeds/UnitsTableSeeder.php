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
            array('id' => '1','name' => 'PM10 (24hr)'),
            array('id' => '2','name' => 'PM2.5 (24hr)'),
            array('id' => '3','name' => 'NO2 (24hr)'),
            array('id' => '4','name' => 'O3 (8hr)'),
            array('id' => '5','name' => 'CO (8hr)'),
            array('id' => '6','name' => 'SO2 (24hr)'),
            array('id' => '7','name' => 'NH3 (24hr)'),
            array('id' => '8','name' => 'Pb (24hr)',)
        );

        DB::table('units')->insert($units);

    }
}
