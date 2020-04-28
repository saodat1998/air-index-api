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
            $table->id();
			$table->float('value')->nullable();
			$table->string('data_type')->default('A');
			$table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions');
			$table->unsignedBigInteger('date_id');
            $table->foreign('date_id')->references('id')->on('dates');
			$table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
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
