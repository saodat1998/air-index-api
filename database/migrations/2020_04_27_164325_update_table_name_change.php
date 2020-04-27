<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableNameChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('technical_values', 'technician');
        Schema::rename('statistic_values', 'statistic_collector');
        Schema::rename('research_values', 'researcher');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('technician', 'technical_values');
        Schema::rename('statistic_collector', 'statistic_values');
        Schema::rename('researcher', 'research_values');
    }
}
