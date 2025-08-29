
@extends('admin.layouts.app')

@section('content')
<!-- Alpine.js CDN for animation -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="container mx-auto max-w-4xl">

    <!-- Notifikasi sukses jika redirect dengan session 'success' -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms class="mb-8 flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
    </div>
    @endif

    <!-- Notifikasi error jika validasi gagal -->
    @if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms class="mb-8 flex items-center justify-between bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="font-semibold">Gagal menambah buku:</span>
            <ul class="ml-4 list-disc text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button @click="show = false" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Buku Baru</h1>
        <p class="text-gray-600">Isi form di bawah untuk menambahkan buku baru ke sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori Buku -->
                <div class="md:col-span-2">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('category') border-red-500 @enderror" 
                        id="category" 
                        name="category" 
                        value="{{ old('category') }}"
                        placeholder="Masukkan kategori buku"
                        required
                    >
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt Buku -->
                <div class="md:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Excerpt <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('excerpt') border-red-500 @enderror" 
                        id="excerpt" 
                        name="excerpt" 
                        placeholder="Masukkan ringkasan singkat buku"
                        required>{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Buku -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-500 @enderror" 
                        id="description" 
                        name="description" 
                        placeholder="Masukkan deskripsi lengkap buku"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Buku -->
                <div class="md:col-span-2">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('price') border-red-500 @enderror" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}"
                        placeholder="Masukkan harga buku"
                        required
                    >
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Judul Buku -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Buku <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 @enderror" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        placeholder="Masukkan judul buku"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis -->
                <div class="md:col-span-2">
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('author') border-red-500 @enderror" 
                        id="author" 
                        name="author" 
                        value="{{ old('author') }}"
                        placeholder="Masukkan nama penulis"
                        required
                    >
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div class="md:col-span-2">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Cover Buku
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file</span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP, BMP hingga 5MB</p>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.books.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center relative" :disabled="loading">
                    <template x-if="loading">
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </template>
                    <template x-if="!loading">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </template>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Buku'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
