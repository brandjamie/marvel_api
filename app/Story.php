<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'stories';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
