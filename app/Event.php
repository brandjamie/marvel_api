<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    public $incrementing = false;
    
   public function stories()
    {
        return $this->hasMany(EventStory::class);
    }
    public function comics()
    {
        return $this->hasMany(ComicEvent::class);
    }
    public function series()
    {
        return $this->hasMany(EventSeries::class);
    }
    public function characters()
    {
        return $this->hasMany(CharacterEvent::class);
    }
}
