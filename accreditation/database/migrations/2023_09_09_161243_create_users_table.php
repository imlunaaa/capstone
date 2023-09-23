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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('program_id');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_type');
            // $table->smallInteger('isAdmin')->default('0');
            // $table->smallInteger('isAreachair')->default('0');
            // $table->smallInteger('isAreamember')->default('0');
            // $table->smallInteger('isExternal')->default('0');
            // $table->smallInteger('isInternal')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });

        $pass = '$2y$10$sYdGtY2c1zLGM4CNCAjcP.oZ7MvwT7RwKvRGXxtfN./86cgfnfNki';
        DB::table('users')->insert(
            array(
                'id'=>null, 
                'firstname'=>'admin',
                'lastname'=>'admin',
                'campus_id'=>1,
                'program_id'=>1,
                'email'=>'admin@gmail.com',
                'email_verified_at'=> null,
                'password'=>$pass,
                'user_type'=>'admin',
                'remember_token'=> '',
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
        Schema::dropIfExists('users');
    }
};
