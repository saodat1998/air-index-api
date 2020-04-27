<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePollutantValuesTable.
 */
class CreatePollutantValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pollutant_values', function(Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('pollutant_id');
            $table->foreign('pollutant_id')->references('id')->on('pollutants');
			$table->unsignedBigInteger('aqi_category_id');
            $table->foreign('aqi_category_id')->references('id')->on('aqi_categories');
			$table->float('min');
			$table->float('max');

            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pollutant_values');
	}
}
