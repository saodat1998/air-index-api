<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUnitValuesTable.
 */
class CreateUnitValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unit_values', function(Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
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
		Schema::drop('unit_values');
	}
}
