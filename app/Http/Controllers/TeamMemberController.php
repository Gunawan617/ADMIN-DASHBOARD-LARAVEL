<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all team members
        // Filtering will be done on frontend based on use case
        $teamMembers = TeamMember::orderBy('created_at', 'desc')->get();
        return response()->json($teamMembers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:20',
            'src'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('src')) {
            $path = $request->file('src')->store('team_members', 'public');
        }

        $teamMember = TeamMember::create([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'src'  => $path,
        ]);

        return response()->json($teamMember, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teamMember = TeamMember::findOrFail($id);
        return response()->json($teamMember, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teamMember = TeamMember::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'role' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:20',
            'src'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('name')) {
            $teamMember->name = $validated['name'];
        }

        if ($request->has('role')) {
            $teamMember->role = $validated['role'];
        }

        if ($request->has('whatsapp')) {
            $teamMember->whatsapp = $validated['whatsapp'];
        }

        if ($request->hasFile('src')) {
            // hapus file lama kalau ada
            if ($teamMember->src && Storage::disk('public')->exists($teamMember->src)) {
                Storage::disk('public')->delete($teamMember->src);
            }
            $teamMember->src = $request->file('src')->store('team_members', 'public');
        }

        $teamMember->save();

        return response()->json($teamMember, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teamMember = TeamMember::findOrFail($id);

        if ($teamMember->src && Storage::disk('public')->exists($teamMember->src)) {
            Storage::disk('public')->delete($teamMember->src);
        }

        $teamMember->delete();

        return response()->json(['message' => 'Team member deleted successfully'], 200);
    }
}
