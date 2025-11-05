<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    // Public API - Get approved testimonials
    public function index()
    {
        $testimonials = Testimonial::approved()
            ->with('user')
            ->latest('approved_at')
            ->get()
            ->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'name' => $testimonial->name,
                    'batch' => $testimonial->batch,
                    'major' => $testimonial->major,
                    'program' => $testimonial->program,
                    'testimonial' => $testimonial->testimonial,
                    'photo' => $testimonial->photo ? asset('storage/' . $testimonial->photo) : null,
                    'rating' => $testimonial->rating,
                    'approved_at' => $testimonial->approved_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    // User - Get own testimonials
    public function myTestimonials()
    {
        $testimonials = Testimonial::where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    // User - Submit testimonial
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:255',
            'testimonial' => 'required|string|min:50',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        
        // Use photo from user profile if available
        if ($user->photo) {
            $validated['photo'] = $user->photo;
        }

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dikirim dan menunggu persetujuan admin.',
            'data' => $testimonial
        ], 201);
    }

    // User - Update own testimonial (only if pending)
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:255',
            'testimonial' => 'required|string|min:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil diperbarui.',
            'data' => $testimonial
        ]);
    }

    // User - Delete own testimonial (only if pending)
    public function destroy($id)
    {
        $testimonial = Testimonial::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dihapus.'
        ]);
    }

    // Admin - Get all testimonials
    public function adminIndex()
    {
        $testimonials = Testimonial::with(['user', 'approver'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    // Admin - Approve testimonial
    public function approve(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil disetujui.',
            'data' => $testimonial
        ]);
    }

    // Admin - Reject testimonial
    public function reject(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $testimonial->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni ditolak.',
            'data' => $testimonial
        ]);
    }

    // Admin - Delete testimonial
    public function adminDestroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dihapus.'
        ]);
    }
}
