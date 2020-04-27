<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateStatisticValuesTable.
 */
class CreateStatisticValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statistic_values', function(Blueprint $table) {
            $table->id();
            $table->date('date');
			$table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
			$table->float('value');
            $table->unsignedBigInteger('research_value_id');
            $table->foreign('research_value_id')->references('id')->on('research_values');
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
		Schema::drop('statistic_values');
	}
}
