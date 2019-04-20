<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'stories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public function series()
    {
        return $this->hasMany(SeriesStory::class);
    }
    public function comics()
    {
        return $this->hasMany(ComicStory::class);
    }
    public function events()
    {
        return $this->hasMany(EventStory::class);
    }
    public function characters()
    {
        return $this->hasMany(CharacterStory::class);
    }
}
