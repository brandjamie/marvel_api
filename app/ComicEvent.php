<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicEvent extends Model
{
    protected $table = 'comic-event';
    public function comic() {
        return $this->belongsTo(Comic::class);
    }
    public function event() {
        return $this->belongsTo(Event::class);
    }
}
