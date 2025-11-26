@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Detail Alumni</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.alumni.edit', $alumni->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ✏️ Edit
                </a>
                <a href="{{ route('admin.alumni.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ⬅️ Kembali
                </a>
            </div>
        </div>

        <!-- Alumni Detail Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Alumni Photo -->
                <div class="md:w-1/3">
                    <div class="h-80 md:h-full bg-gray-100 flex items-center justify-center">
                        @if($alumni->photo)
                            <img src="{{ asset('storage/' . $alumni->photo) }}"
                                 alt="{{ $alumni->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400 text-center">
                                <div class="text-6xl mb-2">👤</div>
                                <p>Tidak ada foto</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Alumni Details -->
                <div class="md:w-2/3 p-8">
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $alumni->name }}</h2>
                            <p class="text-lg text-gray-600">🎓 Alumni</p>
                        </div>

                        <!-- Batch & Major -->
                        <div class="flex justify-between items-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                Angkatan {{ $alumni->batch }}
                            </span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $alumni->major }}
                            </span>
                        </div>

                        <!-- Alumni Information -->
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Informasi Alumni</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama Lengkap:</span>
                                        <span class="font-medium">{{ $alumni->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Angkatan:</span>
                                        <span class="font-medium">{{ $alumni->batch }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jurusan:</span>
                                        <span class="font-medium">{{ $alumni->major }}</span>
                                    </div>
                                    @if($alumni->whatsapp)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">WhatsApp:</span>
                                        <span class="font-medium">{{ $alumni->whatsapp }}</span>
                                    </div>
                                    @endif
                                    @if($alumni->caption)
                                    <div class="pt-2 border-t">
                                        <span class="text-gray-600">Caption:</span>
                                        <p class="font-medium mt-1">{{ $alumni->caption }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="border-t pt-6">
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Dibuat:</span>
                                    <br>{{ $alumni->created_at->format('d M Y, H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Diupdate:</span>
                                    <br>{{ $alumni->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4">
                            @if($alumni->whatsapp)
                            <a href="https://wa.me/{{ $alumni->whatsapp }}?text=Halo%20{{ urlencode($alumni->name) }},%20saya%20ingin%20bertanya%20tentang%20pengalaman%20di%20{{ urlencode($alumni->major) }}"
                               target="_blank"
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-medium transition-colors text-center">
                                💬 Hubungi via WhatsApp
                            </a>
                            @else
                            <div class="flex-1 bg-gray-400 text-white py-3 px-6 rounded-lg font-medium text-center cursor-not-allowed">
                                💬 WhatsApp Tidak Tersedia
                            </div>
                            @endif
                            <form action="{{ route('admin.alumni.destroy', $alumni->id) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Yakin ingin menghapus alumni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                                    🗑️ Hapus Alumni
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
