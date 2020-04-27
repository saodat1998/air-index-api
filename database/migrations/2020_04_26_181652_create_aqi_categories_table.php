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
            $table->string('color');
            $table->float('min')->nullable();
            $table->float('max')->nullable();
            $table->text('health_implications')->nullable();
            $table->text('recommendation')->nullable();
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
