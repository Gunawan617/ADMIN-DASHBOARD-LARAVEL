<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgramNew;
use Illuminate\Http\Request;

class ProgramNewController extends Controller
{
    public function index(Request $request)
    {
        // Get unique majors if requested
        if ($request->has('get_majors')) {
            $majors = ProgramNew::where('is_active', true)
                ->select('major')
                ->distinct()
                ->orderBy('major')
                ->pluck('major');
            return response()->json(['majors' => $majors]);
        }

        $query = ProgramNew::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by major
        if ($request->has('major')) {
            $query->where('major', $request->major);
        }

        // Filter by level
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        $programs = $query->get();

        return response()->json($programs);
    }

    public function show($id)
    {
        $program = ProgramNew::where('is_active', true)->findOrFail($id);
        return response()->json($program);
    }
}
