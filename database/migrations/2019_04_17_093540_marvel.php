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
            $table->integer('id');
            $table->string('name');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('etag');
            $table->string('attribution');
        });
        Schema::create('comics', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->text('description');
            $table->string('etag');
            $table->string('thumbnail');
            $table->string('attribution');
        });
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('etag');
            $table->string('attribution');
        });
        Schema::create('series', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('etag');
            $table->string('attribution');
        });
        Schema::create('stories', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('etag');
            $table->string('attribution');
        });

        // create many to many link tables
        Schema::create('character-comics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('comics_id');                
        });
        Schema::create('character-events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('events_id');                
        });
        Schema::create('character-series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('series_id');                
        });
        Schema::create('character-stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('character_id');
            $table->integer('stories_id');                
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
