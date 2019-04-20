<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesStory extends Model
{
  protected $table = 'series-story';
    public function story() {
        return $this->belongsTo(Story::class);
    }
    public function series() {
        return $this->belongsTo(Series::class);
    }
}
