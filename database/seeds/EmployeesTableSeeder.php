<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
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

        /* `air`.`employees` */
        $employees = array(
            array('id' => 1, 'department_id' => 1, 'user_id' => 1),
            array('id' => 2, 'department_id' => 2, 'user_id' => 2),
            array('id' => 3, 'department_id' => 3, 'user_id' => 3),
        );

        DB::table('employees')->insert($employees);

    }
}
