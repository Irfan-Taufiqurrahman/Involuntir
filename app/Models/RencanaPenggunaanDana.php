<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaPenggunaanDana extends Model
{
    use HasFactory;

    public function icon()
    {
        return $this->belongsTo(IconRencanaPenggunaanDana::class);
    }
}
