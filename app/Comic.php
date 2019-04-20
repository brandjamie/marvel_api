<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $table = 'comics';
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function stories()
    {
        return $this->hasMany(ComicStory::class);
    }
    public function events()
    {
        return $this->hasMany(ComicEvent::class);
    }
    public function series()
    {
        return $this->hasMany(ComicSeries::class);
    }
    public function characters()
    {
        return $this->hasMany(CharacterComic::class);
    }

}
