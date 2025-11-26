<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'badge_text',
        'title',
        'description',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'image_url',
        'stat1_value',
        'stat1_label',
        'stat2_value',
        'stat2_label',
        'stat3_value',
        'stat3_label',
        'floating_card_text',
        'floating_card_value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
