<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharactersIndex extends Model
{
    protected $table = 'characters_index';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public function characters() {
        return $this->hasMany(Character::class);
    }

}
