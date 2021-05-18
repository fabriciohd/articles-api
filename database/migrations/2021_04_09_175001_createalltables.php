<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createalltables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('imageUrl')->nullable();
            $table->string('description');
            $table->string('password');
            $table->boolean('approved')->default(false);
            $table->boolean('adm')->default(false);
        });

        Schema::create('categories', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coverUrl');
        });

        Schema::create('articles', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('resume');
            $table->string('coverUrl');
            $table->binary('content');
            $table->integer('userId')->references('id')->on('users');
            $table->integer('categoryId')->references('id')->on('categories');          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('articles');
    }
}
