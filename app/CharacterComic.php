<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterComic extends Model
{
    protected $table = 'character-comic';

    public function comic() {
        return $this->belongsTo(Comic::class);
    }
}
