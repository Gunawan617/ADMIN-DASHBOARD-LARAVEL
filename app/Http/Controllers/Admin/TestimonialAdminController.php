<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $testimonials = Testimonial::with(['user', 'approver'])
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        $pending = Testimonial::where('status', 'pending')->count();
        $approved = Testimonial::where('status', 'approved')->count();
        $rejected = Testimonial::where('status', 'rejected')->count();

        return view('admin.testimonials.index', compact(
            'testimonials',
            'pending',
            'approved',
            'rejected'
        ));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Testimonial approved successfully!');
    }

    public function reject(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $testimonial->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Testimonial rejected.');
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:255',
            'testimonial' => 'required|string|min:50',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        // Set user_id to admin who created it
        $validated['user_id'] = auth()->id();

        // Set approved_at and approved_by if status is approved
        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:255',
            'testimonial' => 'required|string|min:50',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
            'remove_photo' => 'nullable|boolean',
        ]);

        // Handle photo removal
        if ($request->has('remove_photo') && $testimonial->photo) {
            \Storage::disk('public')->delete($testimonial->photo);
            $validated['photo'] = null;
        }

        // Handle new photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($testimonial->photo) {
                \Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        // Update approved_at and approved_by if status changed to approved
        if ($validated['status'] === 'approved' && $testimonial->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo) {
            \Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
}
