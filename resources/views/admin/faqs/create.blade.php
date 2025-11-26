@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar FAQ
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-8 py-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Tambah FAQ Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Isi form di bawah untuk menambahkan pertanyaan baru</p>
        </div>

        <form action="{{ route('admin.faqs.store') }}" method="POST" class="px-8 py-6 space-y-6">
            @csrf

            <div>
                <label for="question" class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="question"
                    name="question"
                    value="{{ old('question') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('question') border-red-500 @enderror"
                    placeholder="Contoh: Bagaimana cara mendaftar program bimbel?"
                />
                @error('question')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="answer" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="answer"
                    name="answer"
                    required
                    rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('answer') border-red-500 @enderror"
                    placeholder="Tulis jawaban lengkap di sini..."
                >{{ old('answer') }}</textarea>
                @error('answer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        name="category"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                    >
                        <option value="">Pilih kategori</option>
                        <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Umum</option>
                        <option value="program" {{ old('category') == 'program' ? 'selected' : '' }}>Program</option>
                        <option value="payment" {{ old('category') == 'payment' ? 'selected' : '' }}>Pembayaran</option>
                        <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Teknis</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                        Urutan
                    </label>
                    <input
                        type="number"
                        id="order"
                        name="order"
                        value="{{ old('order', 0) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-gray-500">Semakin kecil angka, semakin atas posisinya</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                />
                <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                    Aktifkan FAQ ini
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button
                    type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan FAQ
                </button>
                <a
                    href="{{ route('admin.faqs.index') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-all"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
