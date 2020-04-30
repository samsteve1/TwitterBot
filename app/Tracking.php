<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = ['twitter_id'];

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('twitter_id', 'desc');
    }
}
