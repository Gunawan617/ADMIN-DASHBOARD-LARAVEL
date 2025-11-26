<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category',
        'excerpt',
        'description',
        'price',
        'cover_image',
        'audience_type',
        'buy_link',
        'status',
    ];
}
