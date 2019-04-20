<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicSeries extends Model
{
    protected $table = 'comic-series';
    public function comic() {
        return $this->belongsTo(Comic::class);
    }
    public function series() {
        return $this->belongsTo(Series::class);
    }
}
