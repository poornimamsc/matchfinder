<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationOccupationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_occupation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('qualification_type',50);
            $table->string('qualification_details',200);
            $table->string('nature_job',200);
            $table->smallInteger('job_city_id');
            $table->smallInteger('job_state_id');
            $table->string('job_place',200);
            $table->double('monthly_income',8,2);
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
        Schema::dropIfExists('qualification_occupation');
    }
}
