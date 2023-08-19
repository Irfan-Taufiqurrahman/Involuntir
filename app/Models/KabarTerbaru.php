<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabarTerbaru extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'body', 'campaign_id', 'user_id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(KabarTerbaru::class);
    }
}
