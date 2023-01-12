<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = [
        'activity_id',
        'deskripsi'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
