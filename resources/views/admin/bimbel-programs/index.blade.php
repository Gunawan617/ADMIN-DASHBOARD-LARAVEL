
@extends('admin.layouts.app')


@section('content')
<div class="container mx-auto p-6 bg-white shadow rounded-lg">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Daftar Program Bimbel</h1>
        <a href="{{ route('admin.bimbel-programs.create') }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
           + Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Kode</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Kategori</th>
                <th class="border p-2">Gambar</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $program)
                <tr>
                    <td class="border p-2">{{ $program->code }}</td>
                    <td class="border p-2">{{ $program->name }}</td>
                    <td class="border p-2">{{ $program->category }}</td>
                    <td class="border p-2">
                        @if($program->image)
                            <img src="{{ asset('storage/'.$program->image) }}" class="h-12">
                        @else
                            <span class="text-gray-400">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        <a href="{{ route('admin.bimbel-programs.edit', $program) }}" 
                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>

                        <form action="{{ route('admin.bimbel-programs.destroy', $program) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $programs->links() }}
    </div>
</div>
@endsection
