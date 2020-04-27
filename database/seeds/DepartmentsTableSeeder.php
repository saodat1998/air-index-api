<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
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

        /* `air`.`departments` */
        $departments = array(
            array('id' => '1','name' => 'Technical'),
            array('id' => '2','name' => 'Researchers'),
            array('id' => '3','name' => 'Statistic'),
        );

        DB::table('departments')->insert($departments);

    }
}
