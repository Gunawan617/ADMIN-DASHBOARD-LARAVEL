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

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo) {
            \Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
}
