<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Activity extends Model
{
    use HasFactory, SoftDeletes;
    use Sluggable;
    protected $table = "activities";

    protected $fillable = [
        'category_id',
        'user_id',
        'judul_activity',
        'judul_slug',
        'foto_activity',
        'detail_activity',
        'batas_waktu',
        'waktu_activity',
        'lokasi',
        'tipe_activity',
        'penyelenggaraan_activity',
        'status_publish',
        'status',
        'kuota'
    ];

    protected $casts = ['kuota' => 'integer'];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            'judul_slug' => [
                'source' => 'judul_activity'
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
