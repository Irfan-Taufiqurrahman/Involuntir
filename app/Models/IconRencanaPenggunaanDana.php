<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IconRencanaPenggunaanDana extends Model
{
    use HasFactory;

    public function rencana()
    {
        return $this->hasOne(RencanaPenggunaanDana::class);
    }
}
