<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->smallInteger('city_id');
            $table->smallInteger('state_id');
            $table->string('place_name',100);
            $table->string('pincode',10);
            $table->string('address_line1',100);
            $table->string('address_line2',100);
            $table->string('address_line3',100);
            $table->string('address_line4',100); 
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
        Schema::dropIfExists('present_address');
    }
}
