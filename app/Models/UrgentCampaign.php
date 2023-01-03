<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgentCampaign extends Model
{
    use HasFactory;

    protected $fillable = ["campaign_id"];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
