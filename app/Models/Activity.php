<?php

namespace App\Models;

use App\Enums\ActivityType;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;
    use Sluggable;

    protected $table = 'activities';

    protected $guarded = [];

    protected $casts = ['kuota' => 'integer', 'jenis_activity' => ActivityType::class];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            'judul_slug' => [
                'source' => 'judul_activity',
            ],
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTipeActivityAttribute($value)
    {
        if ($value === 'In-Person') {
            return 'Tatap Muka';
        }

        return $value;
    }

    public function prices()
    {
        return $this->hasMany(ActivityPrice::class);
    }

    public function participants()
    {
        return $this->hasMany(Participation::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }
}
