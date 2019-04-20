<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterStory extends Model
{
    protected $table = 'character-story';
    public function story() {
        return $this->belongsTo(Story::class);
    }
    public function character() {
        return $this->belongsTo(Character::class);
    }

}
