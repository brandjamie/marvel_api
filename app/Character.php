<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
