<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasUuids;

$fillable = ['bunny_id', 'name'];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'bunny_id' => '',
        'name' => ''
    ];
}