<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('admin.team_members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team_members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:20',
            'src' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('src')) {
            $path = $request->file('src')->store('team-members', 'public');
        }

        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'whatsapp' => $request->whatsapp,
            'src'  => $path
        ]);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member berhasil ditambahkan!');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.team_members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:20',
            'src' => 'nullable|image|max:2048'
        ]);

        $path = $teamMember->src;
        if ($request->hasFile('src')) {
            $path = $request->file('src')->store('team-members', 'public');
        }

        $teamMember->update([
            'name' => $request->name,
            'role' => $request->role,
            'whatsapp' => $request->whatsapp,
            'src'  => $path
        ]);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member berhasil diperbarui!');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('admin.team-members.index')->with('success', 'Team member berhasil dihapus!');
    }
}
