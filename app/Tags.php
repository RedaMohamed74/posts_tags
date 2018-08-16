<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
