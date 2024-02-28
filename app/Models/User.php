<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail, CanResetPassword
{
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socialite_id',
        'socialite_name',
        'name',
        'role',
        'tipe',
        'username',
        'email',
        'email_verified_at',
        'password',
        'status_akun',
        'no_telp',
        'usia',
        'jenis_kelamin',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'jenis_organisasi',
        'tanggal_berdiri',
        'photo',
        'foto_ktp',
        'bank',
        'no_rek',
        'status',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->username === null) {
                $username = explode('@', $user->email)[0];
                $newUsername = strtolower($username);

                if (User::where('username', $newUsername)->first()) {
                    $newUsername = Str::random(5);
                }
                $user->username = $newUsername;
                $user->save();
            }
        });
    }

    public function campaigns()
    {
        $this->hasMany(Campaign::class);
    }

    public function doaDanKabarBaik()
    {
        $this->hasMany(DoaDanKabarBaik::class);
    }

    public function donations()
    {
        $this->hasMany(Donation::class, '', '');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function kabar_terbaru()
    {
        return $this->hasMany(KabarTerbaru::class);
    }

    public function kode_referal()
    {
        return $this->hasOne(KodeReferal::class, 'id_user');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class)->orderBy('created_at', 'desc');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function company()
    {
        if ($this->tipe !== 'organisasi') {
            return null;
        }

        return $this->hasOne(Company::class);
    }

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function socials()
    {
        return $this->hasMany(SocialLink::class);
    }
}
