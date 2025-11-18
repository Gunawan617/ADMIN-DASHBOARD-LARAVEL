<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoSectionController extends Controller
{
    public function index()
    {
        $videoSections = VideoSection::latest()->paginate(10);
        return view('admin.video-sections.index', compact('videoSections'));
    }

    public function create()
    {
        return view('admin.video-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'video_type' => 'required|in:upload,youtube',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'required_if:video_type,upload|nullable|file|mimes:mp4,webm,mov|max:51200',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'badge_title' => 'required|string|max:255',
            'badge_subtitle' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Handle video based on type
        if ($request->video_type === 'upload' && $request->hasFile('video_file')) {
            $validated['video_url'] = $request->file('video_file')->store('videos', 'public');
            $validated['youtube_url'] = null;
        } elseif ($request->video_type === 'youtube') {
            $validated['video_url'] = null;
            // Extract YouTube video ID from URL
            $validated['youtube_url'] = $this->extractYouTubeId($request->youtube_url);
        }

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_url'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        $validated['video_webm_url'] = null;
        $validated['feature1_icon'] = null;
        $validated['feature1_title'] = null;
        $validated['feature1_description'] = null;
        $validated['feature2_icon'] = null;
        $validated['feature2_title'] = null;
        $validated['feature2_description'] = null;
        $validated['feature3_icon'] = null;
        $validated['feature3_title'] = null;
        $validated['feature3_description'] = null;

        if ($request->has('is_active') && $request->is_active) {
            VideoSection::where('is_active', true)->update(['is_active' => false]);
        }

        VideoSection::create($validated);

        return redirect()->route('admin.video-sections.index')
            ->with('success', 'Video section berhasil ditambahkan');
    }

    private function extractYouTubeId($url)
    {
        // Extract YouTube video ID from various URL formats
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? $url;
    }

    public function edit(VideoSection $videoSection)
    {
        return view('admin.video-sections.edit', compact('videoSection'));
    }

    public function update(Request $request, VideoSection $videoSection)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'video_type' => 'required|in:upload,youtube',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'badge_title' => 'required|string|max:255',
            'badge_subtitle' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Handle video type change
        if ($request->video_type === 'upload') {
            if ($request->hasFile('video_file')) {
                // Delete old video if exists
                if ($videoSection->video_url && !str_starts_with($videoSection->video_url, 'http')) {
                    Storage::disk('public')->delete($videoSection->video_url);
                }
                $validated['video_url'] = $request->file('video_file')->store('videos', 'public');
            }
            $validated['youtube_url'] = null;
        } elseif ($request->video_type === 'youtube') {
            // Delete old uploaded video if switching to YouTube
            if ($videoSection->video_url && !str_starts_with($videoSection->video_url, 'http')) {
                Storage::disk('public')->delete($videoSection->video_url);
            }
            $validated['video_url'] = null;
            $validated['youtube_url'] = $this->extractYouTubeId($request->youtube_url);
        }

        // Upload new thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            if ($videoSection->thumbnail_url && !str_starts_with($videoSection->thumbnail_url, 'http')) {
                Storage::disk('public')->delete($videoSection->thumbnail_url);
            }
            $validated['thumbnail_url'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        if ($request->has('is_active') && $request->is_active) {
            VideoSection::where('id', '!=', $videoSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $videoSection->update($validated);

        return redirect()->route('admin.video-sections.index')
            ->with('success', 'Video section berhasil diupdate');
    }

    public function destroy(VideoSection $videoSection)
    {
        // Delete video file
        if ($videoSection->video_url && !str_starts_with($videoSection->video_url, 'http')) {
            Storage::disk('public')->delete($videoSection->video_url);
        }

        // Delete thumbnail
        if ($videoSection->thumbnail_url && !str_starts_with($videoSection->thumbnail_url, 'http')) {
            Storage::disk('public')->delete($videoSection->thumbnail_url);
        }

        $videoSection->delete();

        return redirect()->route('admin.video-sections.index')
            ->with('success', 'Video section berhasil dihapus');
    }

    public function toggleActive(VideoSection $videoSection)
    {
        if (!$videoSection->is_active) {
            VideoSection::where('is_active', true)->update(['is_active' => false]);
        }
        
        $videoSection->update(['is_active' => !$videoSection->is_active]);

        return redirect()->route('admin.video-sections.index')
            ->with('success', 'Status video section berhasil diubah');
    }
}
