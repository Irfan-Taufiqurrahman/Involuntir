<?php

namespace App\Models;

use App\Enums\LinkType;
use Illuminate\Database\Eloquent\Model;

class socialLink extends Model
{

    protected $guarded = [];

    protected $casts = [
        'name' => LinkType::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getUrlAttribute($value)
    {
        return $this->attributes['url'] = $this->attributes['url'] ?
            $this->attributes['url'] :
            LinkType::from($this->attributes['name'])->fullUrl(strtolower($this->attributes['username']));
    }

    public function setUsernameAttribute($value)
    {
        return $this->attributes['username'] = strtolower($value);
    }

    public function getUsernameAttribute($value)
    {
        return $this->attributes['username'] = strtolower($value);
    }
}
