<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramNew extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tag',
        'card_type',
        'sold_count',
        'features',
        'price',
        'link',
        'type',
        'major',
        'level',
        'order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];
}
