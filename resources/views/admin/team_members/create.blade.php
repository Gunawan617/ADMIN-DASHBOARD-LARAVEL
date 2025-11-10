@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl">

    <!-- Notifikasi error -->
    @if ($errors->any())
    <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg">
        <strong>Gagal menyimpan data:</strong>
        <ul class="ml-4 list-disc text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Team Member</h1>
        <p class="text-gray-600">Isi form di bawah untuk menambahkan anggota tim baru</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama member"
                        required
                    >
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role / Jabatan
                        <span class="ml-2 text-xs font-normal text-blue-600">(Penting untuk tampil di website)</span>
                    </label>
                    <input 
                        type="text" 
                        id="role" 
                        name="role"
                        value="{{ old('role') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Marketing Manager, Customer Service"
                    >
                    <div class="mt-2 bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                        <p class="text-sm text-blue-800">
                            <strong>ℹ️ Info:</strong> Member dengan <strong>Role</strong> bisa dipilih di halaman Daftar. 
                            Semua member (dengan atau tanpa role) tetap tampil di section "Tim Kami" di homepage.
                        </p>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input 
                        type="text" 
                        id="whatsapp" 
                        name="whatsapp"
                        value="{{ old('whatsapp') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 628123456789"
                    >
                    <p class="mt-1 text-sm text-gray-500">Format: 628xxx (tanpa tanda +, spasi, atau tanda hubung)</p>
                </div>

                <!-- Foto -->
                <div>
                    <label for="src" class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                    <input 
                        type="file" 
                        id="src" 
                        name="src" 
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                    >
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Max 2MB.</p>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.team-members.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Simpan Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
