<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramDetailController extends Controller
{
    /**
     * Parse textarea fields into JSON arrays
     */
    private function parseTextareaFields(Request $request)
    {
        $parsed = [];

        // Parse features
        if (!empty($request->features_text)) {
            $features = array_filter(array_map('trim', explode("\n", $request->features_text)));
            if (!empty($features)) {
                $parsed['features'] = json_encode(array_values($features));
            }
        }

        // Parse schedule
        if (!empty($request->schedule_text)) {
            $scheduleLines = array_filter(array_map('trim', explode("\n", $request->schedule_text)));
            $schedule = [];
            foreach ($scheduleLines as $line) {
                $parts = array_map('trim', explode('|', $line));
                if (count($parts) >= 2) {
                    $schedule[] = ['week' => $parts[0], 'topic' => $parts[1]];
                }
            }
            if (!empty($schedule)) {
                $parsed['schedule'] = json_encode($schedule);
            }
        }

        // Parse packages
        if (!empty($request->packages_text)) {
            $packageLines = array_filter(array_map('trim', explode("\n", $request->packages_text)));
            $packages = [];
            foreach ($packageLines as $line) {
                $parts = array_map('trim', explode('|', $line));
                if (count($parts) >= 4) {
                    $packages[] = [
                        'name' => $parts[0],
                        'topic' => $parts[1],
                        'questions' => $parts[2],
                        'duration' => $parts[3]
                    ];
                }
            }
            if (!empty($packages)) {
                $parsed['packages'] = json_encode($packages);
            }
        }

        return $parsed;
    }

    public function index()
    {
        $programs = ProgramDetail::latest()->paginate(20);
        return view('admin.program-details.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program-details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule_info' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'product_type' => 'required|in:bimbel,tryout,books,video',
            'audience_type' => 'required|in:nurse,midwife',
            'tag' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'students' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'questions' => 'nullable|string|max:100',
            'pages' => 'nullable|string|max:100',
            'features_text' => 'nullable|string',
            'schedule_text' => 'nullable|string',
            'packages_text' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Parse textarea fields
        $parsedFields = $this->parseTextareaFields($request);
        $validated = array_merge($validated, $parsedFields);

        // Remove text fields before saving
        unset($validated['features_text'], $validated['schedule_text'], $validated['packages_text']);

        ProgramDetail::create($validated);

        return redirect()->route('admin.program-details.index')
            ->with('success', 'Program berhasil ditambahkan');
    }

    public function edit(ProgramDetail $programDetail)
    {
        return view('admin.program-details.edit', compact('programDetail'));
    }

    public function update(Request $request, ProgramDetail $programDetail)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule_info' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'product_type' => 'required|in:bimbel,tryout,books,video',
            'audience_type' => 'required|in:nurse,midwife',
            'tag' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'students' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'questions' => 'nullable|string|max:100',
            'pages' => 'nullable|string|max:100',
            'features_text' => 'nullable|string',
            'schedule_text' => 'nullable|string',
            'packages_text' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($programDetail->image) {
                \Storage::disk('public')->delete($programDetail->image);
            }
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Parse textarea fields
        $parsedFields = $this->parseTextareaFields($request);
        $validated = array_merge($validated, $parsedFields);

        // Remove text fields before saving
        unset($validated['features_text'], $validated['schedule_text'], $validated['packages_text']);

        $programDetail->update($validated);

        return redirect()->route('admin.program-details.index')
            ->with('success', 'Program berhasil diperbarui');
    }

    public function destroy(ProgramDetail $programDetail)
    {
        if ($programDetail->image) {
            \Storage::disk('public')->delete($programDetail->image);
        }

        $programDetail->delete();

        return redirect()->route('admin.program-details.index')
            ->with('success', 'Program berhasil dihapus');
    }

    // API Endpoints
    public function apiIndex()
    {
        $programs = ProgramDetail::where('status', 'published')->get();
        
        // Decode JSON fields manually for each program
        $programsData = $programs->map(function($program) {
            $data = $program->toArray();
            foreach (['features', 'schedule', 'benefits', 'packages'] as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = json_decode($data[$field], true);
                }
            }
            // Convert image path to full URL (only if it's a local path, not external URL)
            if (!empty($data['image']) && !filter_var($data['image'], FILTER_VALIDATE_URL)) {
                $data['image'] = asset('storage/' . $data['image']);
            }
            return $data;
        });
        
        return response()->json([
            'success' => true,
            'data' => $programsData
        ]);
    }

    public function apiShow($slug)
    {
        $program = ProgramDetail::where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }

        // Decode JSON fields manually
        $programData = $program->toArray();
        foreach (['features', 'schedule', 'benefits', 'packages'] as $field) {
            if (isset($programData[$field]) && is_string($programData[$field])) {
                $programData[$field] = json_decode($programData[$field], true);
            }
        }

        // Convert image path to full URL (only if it's a local path, not external URL)
        if (!empty($programData['image']) && !filter_var($programData['image'], FILTER_VALIDATE_URL)) {
            $programData['image'] = asset('storage/' . $programData['image']);
        }

        return response()->json([
            'success' => true,
            'data' => $programData
        ]);
    }
}
