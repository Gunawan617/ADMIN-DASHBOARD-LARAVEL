<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_type',
        'youtube_url',
        'video_url',
        'video_webm_url',
        'thumbnail_url',
        'badge_title',
        'badge_subtitle',
        'feature1_icon',
        'feature1_title',
        'feature1_description',
        'feature2_icon',
        'feature2_title',
        'feature2_description',
        'feature3_icon',
        'feature3_title',
        'feature3_description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
