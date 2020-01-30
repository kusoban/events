<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_type_pivot', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('place_type_id');
            $table->unsignedBigInteger('place_id');

            $table->foreign('place_type_id')->references('id')->on('place_types');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_place');
    }
}
