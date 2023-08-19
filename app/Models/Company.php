<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'location', 'address', 'latitude', 'longitude', 'product_type', 'photo', 'coin_discount', 'discount_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
