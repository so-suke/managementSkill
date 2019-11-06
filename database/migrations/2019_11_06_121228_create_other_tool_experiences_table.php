<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherToolExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_tool_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('other_tool_id');
            $table->unsignedBigInteger('experience_period_id');
            $table->timestamps();

            $table->unique(['employee_id', 'other_tool_id']);

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('other_tool_id')->references('id')->on('other_tools');
            $table->foreign('experience_period_id')->references('id')->on('experience_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_tool_experiences');
    }
}
