@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl px-2 sm:px-6 lg:px-8 py-8">

    <!-- Notifikasi sukses -->
    @if(session('success'))
    <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg flex justify-between items-center">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
    </div>
    @endif

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1 tracking-tight">Daftar Team Member</h1>
            <p class="text-gray-500 text-base">Kelola semua anggota tim yang sudah ditambahkan</p>
        </div>
        <a href="{{ route('admin.team-members.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Member
        </a>
    </div>

    <!-- Tabel Team Member -->
    <div class="bg-white/90 rounded-2xl shadow-xl ring-1 ring-gray-100 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-widest">Foto</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-widest">Nama</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($teamMembers as $member)
                <tr class="hover:bg-blue-50/60 transition">
                    <td class="px-6 py-4 align-middle">
                        @if($member->src)
                            <img src="{{ asset('storage/' . $member->src) }}" alt="foto {{ $member->name }}" class="h-14 w-14 object-cover rounded-full border-2 border-blue-200 shadow-sm">
                        @else
                            <span class="text-gray-400 italic">No Image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 align-middle font-semibold text-gray-900">{{ $member->name }}</td>
                    <td class="px-6 py-4 align-middle text-center space-x-2">
                        <a href="{{ route('admin.team-members.edit', $member->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-400 text-gray-900 font-semibold rounded-lg shadow hover:bg-yellow-500 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h18"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-6 text-center text-gray-400 italic bg-gray-50">
                        Belum ada anggota tim ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
