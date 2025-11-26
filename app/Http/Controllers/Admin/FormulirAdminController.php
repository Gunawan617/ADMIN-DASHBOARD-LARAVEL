<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use Illuminate\Http\Request;

class FormulirAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Formulir::with('teamMember');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis program
        if ($request->filled('jenis_program')) {
            $query->where('jenis_program', $request->jenis_program);
        }

        // Filter by team member
        if ($request->filled('team_member_id')) {
            $query->where('team_member_id', $request->team_member_id);
        }

        $formulir = $query->orderBy('created_at', 'desc')->paginate(15);
        $teamMembers = \App\Models\TeamMember::all();
        
        return view('admin.formulir.index', compact('formulir', 'teamMembers'));
    }

    public function show($id)
    {
        $formulir = Formulir::findOrFail($id);
        return view('admin.formulir.show', compact('formulir'));
    }

    public function updateStatus(Request $request, $id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->route('admin.formulir.index')->with('error', 'Tidak ada formulir yang dipilih');
        }
        
        $count = Formulir::whereIn('id', $ids)->delete();
        
        return redirect()->route('admin.formulir.index')->with('success', "$count formulir berhasil dihapus");
    }

    public function destroy($id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();
        
        return redirect()->route('admin.formulir.index')->with('success', 'Formulir berhasil dihapus');
    }
}
