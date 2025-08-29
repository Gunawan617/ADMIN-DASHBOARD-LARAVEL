@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Buku</h1>
        <p class="text-gray-600">Perbarui informasi buku yang sudah ada</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                        value="{{ old('category', $book->category) }}"
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
                        required>{{ old('excerpt', $book->excerpt) }}</textarea>
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
                        required>{{ old('description', $book->description) }}</textarea>
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
                        value="{{ old('price', $book->price) }}"
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
                        value="{{ old('title', $book->title) }}"
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
                        value="{{ old('author', $book->author) }}"
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
                    
                    <!-- Current Cover Preview -->
                    @if($book->cover_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                            <div class="inline-block relative">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                     alt="Current cover" 
                                     class="h-32 w-24 object-cover rounded-lg shadow-md border border-gray-200">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload New Cover -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file baru</span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP, BMP hingga 5MB</p>
                            @if($book->cover_image)
                                <p class="text-xs text-amber-600">Upload file baru untuk mengganti cover yang ada</p>
                            @endif
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
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Update Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
