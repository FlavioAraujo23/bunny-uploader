<?php

namespace App\Models;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Video extends Model
{
    protected $fillable = ['bunny_video_id', 'collection_id', 'name', 'status'];
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}