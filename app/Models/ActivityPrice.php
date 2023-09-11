<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityPrice extends Model
{

    protected $guarded = [];

    public function Activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
