<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use Illuminate\Http\Request;

class FormulirAdminController extends Controller
{
    public function index()
    {
        $formulir = Formulir::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.formulir.index', compact('formulir'));
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
