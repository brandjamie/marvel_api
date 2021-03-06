<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterSeries extends Model
{
    protected $table = 'character-series';
    public function series() {
        return $this->belongsTo(Series::class);
    }
    public function character() {
        return $this->belongsTo(Character::class);
    }

}
