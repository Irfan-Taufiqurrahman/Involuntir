<?php

namespace App\Models;

use App\Enums\ParticipationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'nomor_hp',
        'akun_linkedin',
        'pesan',
        'status',
        'kode_transaksi',
    ];

    protected $casts = ['status' => ParticipationStatus::class];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
