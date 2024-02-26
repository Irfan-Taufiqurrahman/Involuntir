<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'activityId',
        'name',
        'nominal',
        'deadline',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activityId');
    }
}
