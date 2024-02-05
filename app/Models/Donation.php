<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'activity_id', 'judul_slug', 'biaya_persen', 'donasi', 'kode_donasi', 'perantara_donasi', 'metode_pembayaran', 'email', 'nomor_telp', 'status_donasi', 'snap_token', 'payment_url', 'komentar', 'deadline', 'tanggal_donasi', 'emoney_name', 'bank_name', 'qr_code','nomor_va'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function donations()
    {
        return $this->belongsTo(User::class);
    }
}