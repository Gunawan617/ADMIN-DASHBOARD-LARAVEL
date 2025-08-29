@extends('admin.layout')

@section('title', 'Detail Buku')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Detail Buku</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.books.edit', $book->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ✏️ Edit
                </a>
                <a href="{{ route('admin.books.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ⬅️ Kembali
                </a>
            </div>
        </div>

        <!-- Book Detail Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Book Image -->
                <div class="md:w-1/3">
                    <div class="h-80 md:h-full bg-gray-100 flex items-center justify-center">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 alt="{{ $book->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400 text-center">
                                <div class="text-6xl mb-2">📚</div>
                                <p>Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Details -->
                <div class="md:w-2/3 p-8">
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $book->title }}</h2>
                            <p class="text-lg text-gray-600">👨‍⚕️ {{ $book->author }}</p>
                        </div>

                        <!-- Category & Price -->
                        <div class="flex justify-between items-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $book->category }}
                            </span>
                            <span class="text-2xl font-bold text-green-600">{{ $book->price }}</span>
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Ringkasan</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->excerpt }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Lengkap</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>

                        <!-- Meta Information -->
                        <div class="border-t pt-6">
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Dibuat:</span>
                                    <br>{{ $book->created_at->format('d M Y, H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Diupdate:</span>
                                    <br>{{ $book->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4">
                            <a href="https://wa.me/6281295012668?text=Halo,%20saya%20ingin%20membeli%20buku%20{{ urlencode($book->title) }}%20seharga%20{{ urlencode($book->price) }}"
                               target="_blank"
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-medium transition-colors text-center">
                                🛒 Beli via WhatsApp
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                                    🗑️ Hapus Buku
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
