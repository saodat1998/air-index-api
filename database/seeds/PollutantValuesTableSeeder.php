<?php

use Illuminate\Database\Seeder;

class PollutantValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* `air`.`pollutant_values` */
        $pollutant_values = array(
            array('id' => '1','pollutant_id' => '1','aqi_category_id' => '1','min' => '0.00','max' => '54.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','pollutant_id' => '1','aqi_category_id' => '2','min' => '55.00','max' => '70.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','pollutant_id' => '1','aqi_category_id' => '4','min' => '86.00','max' => '105.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '4','pollutant_id' => '1','aqi_category_id' => '5','min' => '106.00','max' => '200.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '5','pollutant_id' => '2','aqi_category_id' => '3','min' => '125.00','max' => '164.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '6','pollutant_id' => '3','aqi_category_id' => '1','min' => '0.00','max' => '12.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '7','pollutant_id' => '3','aqi_category_id' => '2','min' => '12.10','max' => '35.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '8','pollutant_id' => '3','aqi_category_id' => '3','min' => '35.50','max' => '55.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '9','pollutant_id' => '3','aqi_category_id' => '4','min' => '55.50','max' => '150.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '10','pollutant_id' => '3','aqi_category_id' => '5','min' => '150.50','max' => '250.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '11','pollutant_id' => '3','aqi_category_id' => '6','min' => '250.50','max' => '350.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '12','pollutant_id' => '3','aqi_category_id' => '6','min' => '350.50','max' => '500.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '13','pollutant_id' => '4','aqi_category_id' => '1','min' => '0.00','max' => '54.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','pollutant_id' => '4','aqi_category_id' => '2','min' => '55.00','max' => '154.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '15','pollutant_id' => '4','aqi_category_id' => '3','min' => '155.00','max' => '254.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '16','pollutant_id' => '4','aqi_category_id' => '4','min' => '255.00','max' => '354.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '17','pollutant_id' => '4','aqi_category_id' => '5','min' => '355.00','max' => '424.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '18','pollutant_id' => '4','aqi_category_id' => '6','min' => '425.00','max' => '504.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '19','pollutant_id' => '4','aqi_category_id' => '6','min' => '505.00','max' => '604.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '20','pollutant_id' => '5','aqi_category_id' => '1','min' => '0.00','max' => '4.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '21','pollutant_id' => '5','aqi_category_id' => '2','min' => '4.50','max' => '9.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '22','pollutant_id' => '5','aqi_category_id' => '3','min' => '9.50','max' => '12.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '23','pollutant_id' => '5','aqi_category_id' => '4','min' => '12.50','max' => '15.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '24','pollutant_id' => '5','aqi_category_id' => '5','min' => '15.50','max' => '30.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '25','pollutant_id' => '5','aqi_category_id' => '6','min' => '30.50','max' => '40.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '26','pollutant_id' => '5','aqi_category_id' => '6','min' => '40.50','max' => '50.40','created_at' => NULL,'updated_at' => NULL),
            array('id' => '27','pollutant_id' => '6','aqi_category_id' => '1','min' => '0.00','max' => '35.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '28','pollutant_id' => '6','aqi_category_id' => '2','min' => '36.00','max' => '75.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '29','pollutant_id' => '6','aqi_category_id' => '3','min' => '76.00','max' => '185.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '30','pollutant_id' => '6','aqi_category_id' => '4','min' => '186.00','max' => '304.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '31','pollutant_id' => '7','aqi_category_id' => '5','min' => '305.00','max' => '604.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '32','pollutant_id' => '7','aqi_category_id' => '6','min' => '605.00','max' => '804.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '33','pollutant_id' => '7','aqi_category_id' => '6','min' => '805.00','max' => '1004.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '34','pollutant_id' => '8','aqi_category_id' => '1','min' => '0.00','max' => '53.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '35','pollutant_id' => '8','aqi_category_id' => '2','min' => '54.00','max' => '100.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '36','pollutant_id' => '8','aqi_category_id' => '3','min' => '101.00','max' => '360.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '37','pollutant_id' => '8','aqi_category_id' => '4','min' => '361.00','max' => '649.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '38','pollutant_id' => '8','aqi_category_id' => '5','min' => '650.00','max' => '1249.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '39','pollutant_id' => '8','aqi_category_id' => '6','min' => '1250.00','max' => '1649.00','created_at' => NULL,'updated_at' => NULL),
            array('id' => '40','pollutant_id' => '8','aqi_category_id' => '6','min' => '1650.00','max' => '2049.00','created_at' => NULL,'updated_at' => NULL)
        );

        DB::table('pollutant_values')->insert($pollutant_values);

    }
}
