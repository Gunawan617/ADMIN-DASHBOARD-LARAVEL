<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormulirController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'jenis_program' => 'required|in:bimbel,tryout',
            'team_member_id' => 'nullable|exists:team_members,id',
            'pesan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $formulir = Formulir::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Formulir pendaftaran berhasil dikirim!',
            'data' => $formulir,
            'admin_whatsapp' => env('ADMIN_WHATSAPP_NUMBER', '')
        ], 201);
    }

    public function index()
    {
        $formulir = Formulir::orderBy('created_at', 'desc')->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $formulir
        ]);
    }

    public function show($id)
    {
        $formulir = Formulir::find($id);

        if (!$formulir) {
            return response()->json([
                'success' => false,
                'message' => 'Formulir tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $formulir
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $formulir = Formulir::find($id);

        if (!$formulir) {
            return response()->json([
                'success' => false,
                'message' => 'Formulir tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,contacted,registered',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $formulir->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate',
            'data' => $formulir
        ]);
    }

    public function destroy($id)
    {
        $formulir = Formulir::find($id);

        if (!$formulir) {
            return response()->json([
                'success' => false,
                'message' => 'Formulir tidak ditemukan'
            ], 404);
        }

        $formulir->delete();

        return response()->json([
            'success' => true,
            'message' => 'Formulir berhasil dihapus'
        ]);
    }
}
