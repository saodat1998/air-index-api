<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateResearchValuesTable.
 */
class CreateResearchValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('research_values', function(Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('technical_value_id');
			$table->float('value');
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
		Schema::drop('research_values');
	}
}
