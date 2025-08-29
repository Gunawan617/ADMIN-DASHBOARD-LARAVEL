<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BimbelProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BimbelProgramController extends Controller
{
    public function index()
    {
        $programs = BimbelProgram::latest()->paginate(10);
        return view('admin.bimbel-programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.bimbel-programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:bimbel_programs',
            'name' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:20480'
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/bimbel', 'public');
        }

        BimbelProgram::create($data);
        return redirect()->route('admin.bimbel-programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit(BimbelProgram $bimbelProgram)
    {
        return view('admin.bimbel-programs.edit', compact('bimbelProgram'));
    }

    public function update(Request $request, BimbelProgram $bimbelProgram)
    {
        $request->validate([
            'code' => 'required|unique:bimbel_programs,code,' . $bimbelProgram->id,
            'name' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:20480'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($bimbelProgram->image) {
                Storage::disk('public')->delete($bimbelProgram->image);
            }
            $data['image'] = $request->file('image')->store('uploads/bimbel', 'public');
        }

        $bimbelProgram->update($data);
        return redirect()->route('admin.bimbel-programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(BimbelProgram $bimbelProgram)
    {
        if ($bimbelProgram->image) {
            Storage::disk('public')->delete($bimbelProgram->image);
        }

        $bimbelProgram->delete();
        return redirect()->route('admin.bimbel-programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
