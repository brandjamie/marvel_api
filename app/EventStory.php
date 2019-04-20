<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStory extends Model
{
    protected $table = 'event-story';
    public function event() {
        return $this->belongsTo(Event::class);
    }
    public function story() {
        return $this->belongsTo(Story::class);
    }
}
