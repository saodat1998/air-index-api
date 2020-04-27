<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAqiCategoriesTable.
 */
class CreateAqiCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aqi_categories', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('max')->nullable();
            $table->float('min')->nullable();
            $table->float('avg')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->text('description')->nullable();

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
		Schema::drop('aqi_categories');
	}
}
