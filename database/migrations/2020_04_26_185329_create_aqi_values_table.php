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
            $table->date('date')->nullable();
			$table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
			$table->float('value');

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
