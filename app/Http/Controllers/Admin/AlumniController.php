<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Http\Requests\StoreAlumniRequest;
use App\Http\Requests\UpdateAlumniRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $alumni = Alumni::all();
            return response()->json($alumni);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of alumni for admin web interface.
     */
    public function indexWeb()
    {
        $alumni = Alumni::all();
        return view('admin.alumni.index', compact('alumni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alumni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlumniRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('alumni', 'public');
        }
        $alumni = Alumni::create($data);
        return response()->json($alumni, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        return response()->json($alumni);
    }

    /**
     * Display the specified alumni for admin web interface.
     */
    public function showWeb(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('admin.alumni.show', compact('alumni'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('admin.alumni.edit', compact('alumni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlumniRequest $request, string $id)
    {
        $alumni = Alumni::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
                Storage::disk('public')->delete($alumni->photo);
            }
            $data['photo'] = $request->file('photo')->store('alumni', 'public');
        }
        $alumni->update($data);
        return response()->json($alumni);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
            Storage::disk('public')->delete($alumni->photo);
        }
        $alumni->delete();
        return response()->json(['message' => 'Alumni deleted successfully.']);
    }

    /* ===========================
     *   WEB METHODS (ADMIN DASHBOARD)
     * =========================== */

    /**
     * Store a newly created alumni from web form.
     */
    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|string|max:10',
            'major' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
        ], [
            'name.required' => 'Nama alumni wajib diisi.',
            'batch.required' => 'Angkatan wajib diisi.',
            'major.required' => 'Jurusan wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF, WebP, BMP.',
            'photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('alumni', 'public');
        }

        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Alumni berhasil ditambahkan.');
    }

    /**
     * Update the specified alumni from web form.
     */
    public function updateWeb(Request $request, string $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|string|max:10',
            'major' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
        ], [
            'name.required' => 'Nama alumni wajib diisi.',
            'batch.required' => 'Angkatan wajib diisi.',
            'major.required' => 'Jurusan wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF, WebP, BMP.',
            'photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
                Storage::disk('public')->delete($alumni->photo);
            }
            $validated['photo'] = $request->file('photo')->store('alumni', 'public');
        }

        $alumni->update($validated);

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Alumni berhasil diperbarui.');
    }

    /**
     * Remove the specified alumni from web interface.
     */
    public function destroyWeb(string $id)
    {
        $alumni = Alumni::findOrFail($id);

        if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
            Storage::disk('public')->delete($alumni->photo);
        }

        $alumni->delete();

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Alumni berhasil dihapus.');
    }

    /**
     * User submit alumni photo (authenticated users only)
     */
    public function userSubmit(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        // Use user data for alumni info
        $data = [
            'name' => $user->name,
            'batch' => $user->batch ?? 'N/A',
            'major' => $user->major ?? 'N/A',
            'caption' => $validated['caption'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('alumni', 'public');
        }

        $alumni = Alumni::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Foto alumni berhasil disubmit',
            'data' => $alumni
        ], 201);
    }
}
