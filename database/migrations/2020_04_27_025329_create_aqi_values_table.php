<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAqiValuesTable.
 */
class CreateAqiValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aqi_values', function(Blueprint $table) {
			$table->id();
            $table->float('value');
            $table->date('date')->nullable();
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
		Schema::drop('aqi_values');
	}
}
