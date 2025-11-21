@extends('admin.layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="container mx-auto max-w-4xl">
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms
                class="mb-8 flex items-center justify-between bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div>
                        <span class="font-semibold">Gagal menambah program:</span>
                        <ul class="ml-4 list-disc text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button @click="show = false" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
            </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Program Baru</h1>
            <p class="text-gray-600">Isi form di bawah untuk menambahkan program baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.program-news.store') }}" method="POST"
                x-data="{ features: ['', ''], loading: false }" @submit="loading = true">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Program <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tag -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tag (Optional)</label>
                        <input type="text" name="tag" value="{{ old('tag') }}" placeholder="Contoh: Terlaris"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Card Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Kartu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="card_type" value="{{ old('card_type') }}" required
                            placeholder="Contoh: Belajar Mandiri"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('card_type') border-red-500 @enderror">
                        @error('card_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Sold Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Terjual</label>
                        <input type="text" name="sold_count" value="{{ old('sold_count') }}"
                            placeholder="Contoh: 450 terjual"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="price" value="{{ old('price') }}" required placeholder="Contoh: 299.000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                        @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Program <span class="text-red-500">*</span>
                        </label>
                        <select name="type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="bimbel" {{ old('type') == 'bimbel' ? 'selected' : '' }}>Bimbel</option>
                            <option value="tryout" {{ old('type') == 'tryout' ? 'selected' : '' }}>Try Out</option>
                            <option value="bundle" {{ old('type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                        </select>
                        @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Major -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jurusan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="major" list="major-list" value="{{ old('major') }}" required
                            placeholder="Ketik atau pilih jurusan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('major') border-red-500 @enderror">
                        <datalist id="major-list">
                            <option value="Keperawatan">
                            <option value="Kebidanan">
                            <option value="Gizi">
                            <option value="Farmasi">
                            <option value="Analis Kesehatan">
                        </datalist>
                        <p class="text-sm text-gray-500 mt-1">Ketik jurusan baru atau pilih dari daftar</p>
                        @error('major')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>





                    <!-- Features -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fitur Program <span class="text-red-500">*</span>
                        </label>
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex gap-2 mb-2">
                                <input type="text" :name="'features[' + index + ']'" x-model="features[index]" required
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan fitur program">
                                <button type="button" @click="features.splice(index, 1)" x-show="features.length > 1"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="features.push('')"
                            class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            + Tambah Fitur
                        </button>
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_active"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit" :disabled="loading"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
                        <span x-show="!loading">Simpan Program</span>
                        <span x-show="loading">Menyimpan...</span>
                    </button>
                    <a href="{{ route('admin.program-news.index') }}"
                        class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection