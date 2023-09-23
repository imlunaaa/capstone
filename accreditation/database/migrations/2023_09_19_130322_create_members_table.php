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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accreditation_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('accreditation_id')->references('id')->on('accreditations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->smallInteger('isMember')->default('1');
            $table->smallInteger('isAreachair')->default('0');
            $table->smallInteger('isAreamember')->default('0');
            $table->smallInteger('isExternal')->default('0');
            $table->smallInteger('isInternal')->default('0');
            $table->smallInteger('isCoordinator')->default('0');
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
        Schema::dropIfExists('members');
    }
};
