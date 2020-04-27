<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTechnicalValuesTable.
 */
class CreateTechnicalValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('technical_values', function(Blueprint $table) {
            $table->increments('id');
			$table->float('value');
			$table->unsignedBigInteger('region_id');
			$table->unsignedBigInteger('employee_id');
            $table->integer('status');

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
		Schema::drop('technical_values');
	}
}
