<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSeries extends Model
{
    protected $table = 'event-series';
    public function event() {
        return $this->belongsTo(Event::class);
    }
    public function series() {
        return $this->belongsTo(Series::class);
    }
}
