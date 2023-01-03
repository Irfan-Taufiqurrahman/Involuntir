<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaYangBaru extends Model
{
    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi'
    ];

    // table
    protected $table = 'ada_yang_barus';
}
