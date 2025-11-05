<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'schedule_info',
        'image',
        'product_type',
        'audience_type',
        'tag',
        'duration',
        'students',
        'level',
        'price',
        'questions',
        'pages',
        'features',
        'schedule',
        'benefits',
        'packages',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    // Use casts to automatically handle JSON encoding/decoding
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'schedule' => 'array',
            'benefits' => 'array',
            'packages' => 'array',
        ];
    }
}
