<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicStory extends Model
{
    protected $table = 'comic-story';
    public function comic() {
        return $this->belongsTo(Comic::class);
    }
    public function story() {
        return $this->belongsTo(Story::class);
    }
}
