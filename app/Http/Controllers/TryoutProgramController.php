<?php

namespace App\Http\Controllers;

use App\Models\TryoutProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TryoutProgramController extends Controller
{
    /* ===========================
     *   API METHODS (JSON)
     * =========================== */
    public function index()
    {
        return $this->successResponse(TryoutProgram::all());
    }

    public function show($id)
    {
        $program = TryoutProgram::find($id);
        return $program
            ? $this->successResponse($program)
            : $this->errorResponse('Data not found', 404);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $program = TryoutProgram::create($validated);

        return $this->successResponse($program, 'Data created successfully', 201);
    }

    public function update(Request $request, $id)
    {
        $program = TryoutProgram::find($id);
        if (!$program) return $this->errorResponse('Data not found', 404);

        $validated = $this->validateData($request, $id);
        $program->update($validated);

        return $this->successResponse($program, 'Data updated successfully');
    }

    public function destroy($id)
    {
        $program = TryoutProgram::find($id);
        if (!$program) return $this->errorResponse('Data not found', 404);

        $program->delete();
        return $this->successResponse(null, 'Data deleted successfully');
    }

    /* ===========================
     *   WEB METHODS (DASHBOARD)
     * =========================== */
    public function indexWeb()
    {
        $programs = TryoutProgram::all();
        return view('admin.tryout-programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.tryout-programs.create');
    }

    public function storeWeb(Request $request)
    {
        $validated = $this->validateData($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tryouts', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        TryoutProgram::create($validated);

        return redirect()->route('admin.tryout-programs.index')
                         ->with('success', 'Tryout berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $program = TryoutProgram::findOrFail($id);
        return view('admin.tryout-programs.edit', compact('program'));
    }

    public function updateWeb(Request $request, $id)
    {
        $program = TryoutProgram::findOrFail($id);
        $validated = $this->validateData($request, $id);

        if ($request->hasFile('image')) {
            if (!empty($program->image)) {
                $oldPath = str_replace('storage/', '', $program->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('tryouts', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $program->update($validated);

        return redirect()->route('admin.tryout-programs.index')
                         ->with('success', 'Tryout berhasil diperbarui.');
    }

    public function destroyWeb($id)
    {
        $program = TryoutProgram::findOrFail($id);

        if (!empty($program->image)) {
            $oldPath = str_replace('storage/', '', $program->image);
            Storage::disk('public')->delete($oldPath);
        }

        $program->delete();

        return redirect()->route('admin.tryout-programs.index')
                         ->with('success', 'Tryout berhasil dihapus.');
    }

    /* ===========================
     *   HELPER FUNCTIONS
     * =========================== */
    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'code' => 'required|unique:tryout_programs,code,' . $id,
            'name' => 'required',
            'category' => 'required',
            'participants' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20048',
            'description' => 'nullable',
        ]);
    }

    private function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    private function errorResponse($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
