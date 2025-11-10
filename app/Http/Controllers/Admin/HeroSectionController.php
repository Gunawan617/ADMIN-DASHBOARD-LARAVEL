<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroSections = HeroSection::latest()->paginate(10);
        return view('admin.hero-sections.index', compact('heroSections'));
    }

    public function create()
    {
        return view('admin.hero-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge_text' => 'required|string|max:255',
            'title' => 'required|string',
            'description' => 'required|string',
            'primary_button_text' => 'required|string|max:255',
            'primary_button_link' => 'required|string|max:255',
            'secondary_button_text' => 'nullable|string|max:255',
            'secondary_button_link' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stat1_value' => 'required|string|max:50',
            'stat1_label' => 'required|string|max:255',
            'stat2_value' => 'required|string|max:50',
            'stat2_label' => 'required|string|max:255',
            'stat3_value' => 'required|string|max:50',
            'stat3_label' => 'required|string|max:255',
            'floating_card_text' => 'required|string|max:255',
            'floating_card_value' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('hero-sections', 'public');
        }

        if ($request->has('is_active') && $request->is_active) {
            HeroSection::where('is_active', true)->update(['is_active' => false]);
        }

        HeroSection::create($validated);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section berhasil ditambahkan');
    }

    public function edit(HeroSection $heroSection)
    {
        return view('admin.hero-sections.edit', compact('heroSection'));
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'badge_text' => 'required|string|max:255',
            'title' => 'required|string',
            'description' => 'required|string',
            'primary_button_text' => 'required|string|max:255',
            'primary_button_link' => 'required|string|max:255',
            'secondary_button_text' => 'nullable|string|max:255',
            'secondary_button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stat1_value' => 'required|string|max:50',
            'stat1_label' => 'required|string|max:255',
            'stat2_value' => 'required|string|max:50',
            'stat2_label' => 'required|string|max:255',
            'stat3_value' => 'required|string|max:50',
            'stat3_label' => 'required|string|max:255',
            'floating_card_text' => 'required|string|max:255',
            'floating_card_value' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($heroSection->image_url) {
                Storage::disk('public')->delete($heroSection->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('hero-sections', 'public');
        }

        if ($request->has('is_active') && $request->is_active) {
            HeroSection::where('id', '!=', $heroSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $heroSection->update($validated);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section berhasil diupdate');
    }

    public function destroy(HeroSection $heroSection)
    {
        if ($heroSection->image_url) {
            Storage::disk('public')->delete($heroSection->image_url);
        }

        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section berhasil dihapus');
    }

    public function toggleActive(HeroSection $heroSection)
    {
        if (!$heroSection->is_active) {
            HeroSection::where('is_active', true)->update(['is_active' => false]);
        }
        
        $heroSection->update(['is_active' => !$heroSection->is_active]);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Status hero section berhasil diubah');
    }
}
