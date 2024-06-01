<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //to create forign key in posts table that links users table to it
            $table->unsignedBigInteger('user_id')->nullable(); //make the column values equal null to accept the users values
            //create column user_id of type unsignedBigInteger

            $table->foreign('user_id')->references('id')->on('users'); 
            //put forign key constraint on user_id column that reference id column from users table
        });
    }
};
