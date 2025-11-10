<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroSection = HeroSection::where('is_active', true)->first();
        
        if (!$heroSection) {
            return response()->json([
                'message' => 'No active hero section found'
            ], 404);
        }

        return response()->json($heroSection);
    }
}
