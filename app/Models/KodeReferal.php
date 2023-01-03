<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Self_;
use Reflector;

class KodeReferal extends Model
{
    use HasFactory;
    public $table = 'kode_referal';
    protected $fillable = ["id_user", "kode_referal"];

    const REF_USER = [
        "Volunteer" => "VLTR",
        "Fundraiser" => "FR",
        "User" => "PDLY",
    ];

    static function getRefUser() {
        return collect(Self::REF_USER);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
