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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('accreditation_name');
            $table->unsignedBigInteger('program_level_id');
            $table->foreign('program_level_id')->references('id')->on('program_levels')->onDelete('cascade');
            $table->string('accreditation_type');
            $table->date('internal_accreditation_date_start');
            $table->date('internal_accreditation_date_end');
            $table->date('external_accreditation_date_start');
            $table->date('external_accreditation_date_end');
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
        Schema::dropIfExists('accreditations');
    }
};
