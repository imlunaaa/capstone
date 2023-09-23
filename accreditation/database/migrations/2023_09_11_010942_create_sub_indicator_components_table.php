<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_indicator_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parameter_id');
            $table->unsignedBigInteger('sub_indicator_id');
            $table->foreign('parameter_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('sub_indicator_id')->references('id')->on('sub_indicators')->onDelete('cascade');
            $table->string('component_name');
            $table->text('component_desc');
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
        Schema::dropIfExists('sub_indicator_components');
    }
};
