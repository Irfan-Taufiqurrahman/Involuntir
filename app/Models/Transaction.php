<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'user_id', 'balance_id', 'amount', 'payment_method', 'payment_name', 'qr_code', 'va_number', 'deadline', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
}
