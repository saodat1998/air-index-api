<?php

use Illuminate\Database\Seeder;

class AqiCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        /* `air`.`aqi_categories` */



        /**
         * Database `air`
         */

        /* `air`.`aqi_categories` */
                    $aqi_categories = array(
                        array('id' => '1','name' => 'Good','min' => '0.00','max' => '50.00','health_implications' => 'No health implications.	','recommendation' => 'Everyone can continue their outdoor activities normally.','description' => 'Minimal impact','created_at' => NULL,'updated_at' => NULL,'color' => '#00b050'),
                        array('id' => '2','name' => 'Moderate','min' => '51.00','max' => '100.00','health_implications' => 'Some pollutants may slightly affect very few hypersensitive individuals.	','recommendation' => 'Only very few hypersensitive people should reduce outdoor activities.','description' => 'May cause minor breathing discomfort to sensitive people.','created_at' => NULL,'updated_at' => NULL,'color' => '#ffff00'),
                        array('id' => '3','name' => 'Unhealthy for Sensitive Groups','min' => '101.00','max' => '150.00','health_implications' => 'Healthy people may experience slight irritations and sensitive individuals will be slightly affected to a larger extent.	','recommendation' => 'Children, seniors and individuals with respiratory or heart diseases should reduce sustained and high-intensity outdoor exercises.','description' => 'May cause breathing discomfort to people with lung disease such as asthma, and discomfort to people with heart disease, children and older adults.','created_at' => NULL,'updated_at' => NULL,'color' => '#ff6600'),
                        array('id' => '4','name' => 'Unhealthy','min' => '151.00','max' => '200.00','health_implications' => 'Sensitive individuals will experience more serious conditions. The hearts and respiratory systems of healthy people may be affected.	','recommendation' => 'Children, seniors and individuals with respiratory or heart diseases should avoid sustained and high-intensity outdoor exercises. General population should moderately reduce outdoor activities.','description' => 'May cause breathing discomfort to people on prolonged exposure, and discomfort to people with heart disease.','created_at' => NULL,'updated_at' => NULL,'color' => '#ff0000'),
                        array('id' => '5','name' => 'Very Unhealthy','min' => '201.00','max' => '300.00','health_implications' => 'Healthy people will commonly show symptoms. People with respiratory or heart diseases will be significantly affected and will experience reduced endurance in activities.	','recommendation' => 'Children, seniors and individuals with heart or lung diseases should stay indoors and avoid outdoor activities. General population should reduce outdoor activities.','description' => 'May cause respiratory illness to the people on prolonged exposure. Effect may be more pronounced in people with lung and heart diseases.','created_at' => NULL,'updated_at' => NULL,'color' => '#7030a0'),
                        array('id' => '6','name' => 'Hazardous1','min' => '301.00','max' => '400.00','health_implications' => 'Healthy people will experience reduced endurance in activities and may also show noticeably strong symptoms. Other illnesses may be triggered in healthy people. Elders and the sick should remain indoors and avoid exercise. Healthy individuals should avoid outdoor activities.	','recommendation' => 'Children, seniors and the sick should stay indoors and avoid physical exertion. General population should avoid outdoor activities.','description' => 'May cause respiratory impact even on healthy people, and serious health impacts on people with lung/heart disease. The health impacts may be experienced even during light physical activity.','created_at' => NULL,'updated_at' => NULL,'color' => '#990033'),
                        array('id' => '7','name' => 'Hazardous2','min' => '401.00','max' => '500.00','health_implications' => 'Healthy people will experience reduced endurance in activities and may also show noticeably strong symptoms. Other illnesses may be triggered in healthy people. Elders and the sick should remain indoors and avoid exercise. Healthy individuals should avoid outdoor activities.	','recommendation' => 'Children, seniors and the sick should stay indoors and avoid physical exertion. General population should avoid outdoor activities.','description' => 'May cause respiratory impact even on healthy people, and serious health impacts on people with lung/heart disease. The health impacts may be experienced even during light physical activity.','created_at' => NULL,'updated_at' => NULL,'color' => '#990033')
                    );

        DB::table('aqi_categories')->insert($aqi_categories);

    }
}
