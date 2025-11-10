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
        <h1 class="text-3xl font-bold text-gray-800 mb-4">📸 Daftar Alumni</h1>
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <a href="{{ route('admin.alumni.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Alumni
            </a>

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('admin.alumni.index') }}" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari nama, angkatan, jurusan..." 
                    value="{{ request('search') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64"
                >
                
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                </select>

                <select name="batch" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Angkatan</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>{{ $batch }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>

                @if(request('search') || request('status') || request('batch'))
                    <a href="{{ route('admin.alumni.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition duration-200 flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="mb-4 text-sm text-gray-600">
        Menampilkan {{ $alumni->firstItem() ?? 0 }} sampai {{ $alumni->lastItem() ?? 0 }} dari {{ $alumni->total() }} alumni
        @if(request('search'))
            <span class="font-semibold">untuk "{{ request('search') }}"</span>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Angkatan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jurusan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Caption</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($alumni as $alum)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $alum->status == 'pending' ? 'bg-yellow-50' : '' }}">
                        <td class="px-4 py-3">
                            @if($alum->photo)
                                <img src="{{ asset('storage/' . $alum->photo) }}" alt="{{ $alum->name }}" class="h-16 w-16 object-cover rounded shadow-sm cursor-pointer" onclick="window.open(this.src, '_blank')"/>
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $alum->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $alum->batch }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $alum->major }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate" title="{{ $alum->caption }}">
                            {{ $alum->caption ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($alum->status == 'approved')
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded whitespace-nowrap">✅ Approved</span>
                            @elseif($alum->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded whitespace-nowrap">⏳ Pending</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded whitespace-nowrap">❌ Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex justify-center gap-1 flex-wrap">
                                @if($alum->status == 'pending')
                                    <form action="{{ route('admin.alumni.approve', $alum->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.alumni.reject', $alum->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                            ❌ Reject
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.alumni.edit', $alum->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.alumni.destroy', $alum->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus alumni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-colors">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                @if(request('search') || request('status') || request('batch'))
                                    <p class="text-lg font-medium">Tidak ada alumni yang sesuai dengan pencarian</p>
                                    <p class="text-sm">Coba ubah filter atau kata kunci pencarian</p>
                                @else
                                    <p class="text-lg font-medium">Belum ada data alumni</p>
                                    <p class="text-sm">Mulai dengan menambahkan alumni pertama Anda</p>
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
        {{ $alumni->links() }}
    </div>
</div>
@endsection
