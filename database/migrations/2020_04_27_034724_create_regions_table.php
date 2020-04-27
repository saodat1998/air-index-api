<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRegionsTable.
 */
class CreateRegionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regions', function(Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('zip_code')->nullable();
			$table->integer('population')->nullable();
			$table->integer('vehicles')->nullable();
			$table->unsignedBigInteger('location_id')->nullable();

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
		Schema::drop('regions');
	}
}
