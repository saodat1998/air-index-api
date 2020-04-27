<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* `air`.`regions` */
        $regions = array(
            array('id' => '1','name' => 'Andijon','hasc' => 'UZ.AN','iso' => 'AN','area_km' => '4,200','area_mi' => '1,600','capital' => 'Andijon','zip_code' => NULL,'population' => '2116000','vehicles' => NULL,'location_id' => NULL,'created_at' => '2020-04-27 11:49:04','updated_at' => '2020-04-27 11:49:00'),
            array('id' => '2','name' => 'Buxoro','hasc' => 'UZ.BU','iso' => 'BU','area_km' => '39,400','area_mi' => '15,200','capital' => 'Buxoro','zip_code' => NULL,'population' => '1379000','vehicles' => NULL,'location_id' => NULL,'created_at' => '2020-04-27 11:48:56','updated_at' => '2020-04-27 11:49:07'),
            array('id' => '3','name' => 'Farg`ona','hasc' => 'UZ.FA	','iso' => 'FA','area_km' => '6,800','area_mi' => '2,600','capital' => 'Farg`ona','zip_code' => NULL,'population' => '2584000','vehicles' => NULL,'location_id' => NULL,'created_at' => '2020-04-27 11:47:36','updated_at' => '2020-04-27 11:47:36'),
            array('id' => '4','name' => 'Jizzax','hasc' => 'UZ.JI','iso' => 'JI','area_km' => '20,500	','area_mi' => '7,900	','capital' => 'Jizzax','zip_code' => NULL,'population' => '924000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '5','name' => 'Karakalpakstan','hasc' => 'UZ.QR	','iso' => 'QR	','area_km' => '165,600','area_mi' => '63,900','capital' => 'Nukus','zip_code' => NULL,'population' => '1456000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '6','name' => 'Kashkadarya','hasc' => 'UZ.QA	','iso' => 'QA	','area_km' => '28,400','area_mi' => '11,000','capital' => 'Karshi','zip_code' => NULL,'population' => '2067000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '7','name' => 'Namangan','hasc' => 'UZ.NG','iso' => 'NG','area_km' => '7900','area_mi' => '3100','capital' => 'Namangan','zip_code' => NULL,'population' => '1858000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '8','name' => 'Navoi','hasc' => 'UZ.NW','iso' => 'NW','area_km' => '110800','area_mi' => '42800','capital' => 'Navoi','zip_code' => NULL,'population' => '769000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '9','name' => 'Samarkand','hasc' => 'UZ.SA','iso' => 'SA','area_km' => '16400','area_mi' => '6300','capital' => 'Samarkand','zip_code' => NULL,'population' => '2585000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '10','name' => 'Sirdaryo','hasc' => 'UZ.SI','iso' => 'SI','area_km' => '5100','area_mi' => '2000','capital' => 'Gulistan','zip_code' => NULL,'population' => '650000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '11','name' => 'Surxondaryo','hasc' => 'UZ.SU','iso' => 'SU','area_km' => '20800	','area_mi' => '8000','capital' => 'Termiz','zip_code' => NULL,'population' => '1660000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '12','name' => 'Tashkent','hasc' => 'UZ.TA','iso' => 'TA','area_km' => '15000','area_mi' => '5800','capital' => 'Tashkent','zip_code' => NULL,'population' => '2311000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '13','name' => 'Tashkent City	','hasc' => 'UZ.TK','iso' => 'TK','area_km' => '300','area_mi' => '100','capital' => 'Tashkent','zip_code' => NULL,'population' => '2138000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','name' => 'Xorazm','hasc' => 'UZ.KH','iso' => 'KH','area_km' => '6300','area_mi' => '2400','capital' => 'Urgench','zip_code' => NULL,'population' => '1272000','vehicles' => NULL,'location_id' => NULL,'created_at' => NULL,'updated_at' => NULL)
        );
        DB::table('regions')->insert($regions);

    }
}
