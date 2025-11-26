@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Daftar Buku</h1>
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <a href="{{ route('admin.books.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Buku
            </a>

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('admin.books.index') }}" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari judul, penulis, kategori..." 
                    value="{{ request('search') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64"
                >
                
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>

                <select name="audience_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Audience</option>
                    <option value="nurse" {{ request('audience_type') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                    <option value="midwife" {{ request('audience_type') == 'midwife' ? 'selected' : '' }}>Midwife</option>
                </select>

                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>

                @if(request('search') || request('status') || request('audience_type') || request('category'))
                    <a href="{{ route('admin.books.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="mb-4 text-sm text-gray-600">
        Menampilkan {{ $books->firstItem() ?? 0 }} sampai {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} buku
        @if(request('search'))
            <span class="font-semibold">untuk "{{ request('search') }}"</span>
        @endif
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-20">Cover</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penulis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Audience</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($books as $book)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-16 w-12 object-cover rounded shadow-sm" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center" style="display:none;">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="font-medium text-gray-900 max-w-xs truncate" title="{{ $book->title }}">{{ $book->title }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $book->price }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $book->author }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded whitespace-nowrap">{{ $book->category }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($book->audience_type == 'nurse')
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded whitespace-nowrap">Nurse</span>
                            @elseif($book->audience_type == 'midwife')
                                <span class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded whitespace-nowrap">Midwife</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($book->status == 'published')
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded whitespace-nowrap">Published</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded whitespace-nowrap">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition-colors">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.747 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                @if(request('search') || request('status') || request('audience_type') || request('category'))
                                    <p class="text-lg font-medium">Tidak ada buku yang sesuai dengan pencarian</p>
                                    <p class="text-sm">Coba ubah filter atau kata kunci pencarian</p>
                                @else
                                    <p class="text-lg font-medium">Belum ada data buku</p>
                                    <p class="text-sm">Mulai dengan menambahkan buku pertama Anda</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>
@endsection
