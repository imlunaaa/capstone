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
        Schema::create('indicator_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->timestamps();
        }); 

        DB::table('indicator_categories')->insert(
            array(
                'id'=>null, 
                'category_name'=> 'NOT APPLICABLE', 
                'created_at'=> NOW(), 
                'updated_at'=> NOW(),
            )
        );
        DB::table('indicator_categories')->insert(
            array(
                'id'=>null, 
                'category_name'=> 'SYSTEM - INPUTS AND PROCESSES', 
                'created_at'=> NOW(), 
                'updated_at'=> NOW(),
            )
        );
        DB::table('indicator_categories')->insert(
            array(
                'id'=>null, 
                'category_name'=> 'OUTCOME/S', 
                'created_at'=> NOW(), 
                'updated_at'=> NOW(),
            )
        );
        DB::table('indicator_categories')->insert(
            array(
                'id'=>null, 
                'category_name'=> 'IMPLEMENTATION', 
                'created_at'=> NOW(), 
                'updated_at'=> NOW(),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicator_categories');
    }
};
