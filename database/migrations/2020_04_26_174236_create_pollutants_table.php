<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePollutantsTable.
 */
class CreatePollutantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pollutants', function(Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('unit_name');
			$table->string('calculation_period')->nullable();
			$table->text('formula')->nullable();
			$table->text('note')->nullable();

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
		Schema::drop('pollutants');
	}
}
