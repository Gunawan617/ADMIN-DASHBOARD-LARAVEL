@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Alumni</h1>
        <p class="text-gray-600">Perbarui informasi alumni yang sudah ada</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.alumni.update', $alumni->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Alumni -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Alumni <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('name') border-red-500 @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name', $alumni->name) }}"
                        placeholder="Masukkan nama lengkap alumni"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Angkatan -->
                <div>
                    <label for="batch" class="block text-sm font-medium text-gray-700 mb-2">
                        Angkatan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('batch') border-red-500 @enderror"
                        id="batch"
                        name="batch"
                        value="{{ old('batch', $alumni->batch) }}"
                        placeholder="Contoh: 2020"
                        required
                    >
                    @error('batch')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jurusan -->
                <div>
                    <label for="major" class="block text-sm font-medium text-gray-700 mb-2">
                        Jurusan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('major') border-red-500 @enderror"
                        id="major"
                        name="major"
                        value="{{ old('major', $alumni->major) }}"
                        placeholder="Contoh: Teknik Informatika"
                        required
                    >
                    @error('major')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div class="md:col-span-2">
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor WhatsApp
                    </label>
                    <input
                        type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('whatsapp') border-red-500 @enderror"
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp', $alumni->whatsapp) }}"
                        placeholder="Contoh: 628123456789 (gunakan format 62)"
                    >
                    <p class="mt-1 text-xs text-gray-500">Format: 62 diikuti nomor tanpa 0 di awal (contoh: 628123456789)</p>
                    @error('whatsapp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Caption -->
                <div class="md:col-span-2">
                    <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">
                        Caption/Keterangan
                    </label>
                    <textarea
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('caption') border-red-500 @enderror"
                        id="caption"
                        name="caption"
                        rows="3"
                        placeholder="Masukkan caption atau keterangan tambahan (opsional)"
                    >{{ old('caption', $alumni->caption) }}</textarea>
                    @error('caption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Alumni -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Alumni
                    </label>

                    <!-- Current Photo Preview -->
                    @if($alumni->photo)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <div class="inline-block relative">
                                <img src="{{ asset('storage/' . $alumni->photo) }}"
                                     alt="Current photo"
                                     class="h-32 w-24 object-cover rounded-lg shadow-md border border-gray-200">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Photo -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file baru</span>
                                    <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP, BMP hingga 5MB</p>
                            @if($alumni->photo)
                                <p class="text-xs text-amber-600">Upload file baru untuk mengganti foto yang ada</p>
                            @endif
                        </div>
                    </div>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.alumni.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Update Alumni
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
