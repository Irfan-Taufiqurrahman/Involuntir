<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = "vouchers";

    protected $fillable = [
        'activity_id',
        'judul_slug_activity',
        'name_voucher',
        'nominal_potongan',
        'deadline',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
