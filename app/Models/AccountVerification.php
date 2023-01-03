<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountVerification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'foto_ktp', 'foto_diri_ktp', 'foto_npwp', 'foto_diri_npwp'];
}
