<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $table = 'comics';
    protected $primaryKey = 'id';
    public $incrementing = false;

}
