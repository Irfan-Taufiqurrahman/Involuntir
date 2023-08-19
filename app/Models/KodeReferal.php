<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeReferal extends Model
{
    use HasFactory;

    public $table = 'kode_referal';

    protected $fillable = ['id_user', 'kode_referal'];

    const REF_USER = [
        'Volunteer' => 'VLTR',
        'Fundraiser' => 'FR',
        'User' => 'PDLY',
    ];

    public static function getRefUser()
    {
        return collect(self::REF_USER);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
