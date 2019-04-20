<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterEvent extends Model
{
    protected $table = 'character-event';

    public function event() {
        return $this->belongsTo(Event::class);
    }
    public function character() {
        return $this->belongsTo(Character::class);
    }

}
