<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function stories()
    {
        return $this->hasMany(SeriesStory::class);
    }
    public function comics()
    {
        return $this->hasMany(ComicSeries::class);
    }
    public function events()
    {
        return $this->hasMany(EventSeries::class);
    }
    public function characters()
    {
        return $this->hasMany(CharacterSeries::class);
    }
}
