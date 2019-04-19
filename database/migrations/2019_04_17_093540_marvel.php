<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Marvel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('etag')->nullable();
            $table->string('attribution')->nullable();
            $table->timestamps();
        });
        Schema::create('comics', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('etag')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('attribution')->nullable();
            $table->timestamps();
        });
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('etag')->nullable();
            $table->string('attribution')->nullable();
            $table->timestamps();
        });
        Schema::create('series', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('etag')->nullable();
            $table->string('attribution')->nullable();
            $table->timestamps();
        });
        Schema::create('stories', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('etag')->nullable();
            $table->string('attribution')->nullable();
            $table->timestamps();
        });

        // create many to many link tables
        Schema::create('character-comics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('comics_id');
            $table->timestamps();
        });
        Schema::create('character-events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('events_id');
            $table->timestamps();
        });
        Schema::create('character-series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('series_id');
            $table->timestamps();
        });
        Schema::create('character-stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('stories_id');
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
        //
        Schema::dropIfExists('characters');
        Schema::dropIfExists('comics');
        Schema::dropIfExists('events');
        Schema::dropIfExists('series');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('character-comics');
        Schema::dropIfExists('character-events');
        Schema::dropIfExists('character-series');
        Schema::dropIfExists('character-stories');
        
    }
}
