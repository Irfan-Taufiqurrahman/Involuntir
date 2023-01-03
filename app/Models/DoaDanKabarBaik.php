<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoaDanKabarBaik extends Model
{
    protected $fillable = ['body'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
