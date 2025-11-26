<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoSection;
use Illuminate\Http\Request;

class VideoSectionController extends Controller
{
    public function index()
    {
        $videoSection = VideoSection::where('is_active', true)->first();
        
        if (!$videoSection) {
            return response()->json([
                'message' => 'No active video section found'
            ], 404);
        }

        return response()->json($videoSection);
    }
}
