<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    protected $fillable = ['bunny_id', 'name'];
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}