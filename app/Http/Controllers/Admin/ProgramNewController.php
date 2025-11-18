<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramNew;
use Illuminate\Http\Request;

class ProgramNewController extends Controller
{
    public function index()
    {
        $programs = ProgramNew::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.program-news.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program-news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'card_type' => 'required|string|max:255',
            'sold_count' => 'nullable|string|max:255',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'price' => 'required|string|max:255',
            'type' => 'required|in:bimbel,tryout,bundle',
            'major' => 'required|string|max:50',
            'level' => 'required|in:d3,profesi,s1',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['link'] = '/daftar';

        ProgramNew::create($validated);

        return redirect()->route('admin.program-news.index')
            ->with('success', 'Program berhasil ditambahkan');
    }

    public function edit($id)
    {
        $program = ProgramNew::findOrFail($id);
        return view('admin.program-news.edit', ['program' => $program]);
    }

    public function update(Request $request, $id)
    {
        $program = ProgramNew::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'card_type' => 'required|string|max:255',
            'sold_count' => 'nullable|string|max:255',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'price' => 'required|string|max:255',
            'type' => 'required|in:bimbel,tryout,bundle',
            'major' => 'required|string|max:50',
            'level' => 'required|in:d3,profesi,s1',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['link'] = '/daftar';

        $program->update($validated);

        return redirect()->route('admin.program-news.index')
            ->with('success', 'Program berhasil diupdate');
    }

    public function destroy($id)
    {
        $program = ProgramNew::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.program-news.index')
            ->with('success', 'Program berhasil dihapus');
    }
}
