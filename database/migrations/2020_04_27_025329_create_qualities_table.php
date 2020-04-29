<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAqiValuesTable.
 */
class CreateQualitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('qualities', function(Blueprint $table) {
			$table->id();
            $table->float('value');
            $table->float('aqi_index')->nullable();
            $table->unsignedBigInteger('aqi_category_id');
            $table->foreign('aqi_category_id')->references('id')->on('aqi_categories');
            $table->unsignedBigInteger('date_id');
            $table->foreign('date_id')->references('id')->on('dates');
            $table->unsignedBigInteger('pollutant_id');
            $table->foreign('pollutant_id')->references('id')->on('pollutants');
            $table->unsignedBigInteger('technical_value_id');
            $table->foreign('technical_value_id')->references('id')->on('technical_values');

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
		Schema::drop('qualities');
	}
}
