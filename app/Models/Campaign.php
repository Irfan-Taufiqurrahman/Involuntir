<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;
    use Sluggable;
    protected $table = "campaigns";

    protected $fillable = [
        'judul_campaign',
        'judul_slug',
        'foto_campaign',
        'nominal_campaign',
        'kategori_campaign',
        'batas_waktu_campaign',
        'detail_campaign',
        'update_campaign',
        'status',
        'regencies',
        'user_id',
        'deleted_at',
        'alamat_lengkap',
        'tujuan',
        'penerima',
        'rincian',
        'foto_campaign_2',
        'foto_campaign_3',
        'foto_campaign_4',
        'campaign_type',
        'kategori_penerima_manfaat',
        'cerita_tentang_pembuat_campaign',
        'cerita_tentang_penerima_manfaat',
        'foto_tentang_campaign',
        'cerita_tentang_masalah_dan_usaha',
        'foto_tentang_campaign_2',
        'berapa_biaya_yang_dibutuhkan',
        'kenapa_galangdana_dibutuhkan',
        'foto_tentang_campaign_3',
        'ajakan',
        'status_publish',
        'category_id',
        'email_sent_at'
    ];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            'judul_slug' => [
                'source' => 'judul_campaign'
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function urgent() {
        return $this->hasOne(UrgentCampaign::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function totalDonations() {
        return $this->donations->sum('donasi');
    }

    public function kabar_terbaru() {
        return $this->hasMany(KabarTerbaru::class);
    }

    public function wishlists() {
        return $this->hasMany(Wishlist::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
