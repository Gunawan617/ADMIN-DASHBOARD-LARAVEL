@extends('admin.layout')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📚 Program Details Management</h1>
    <a href="{{ route('admin.program-details.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
      + Tambah Program
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-3 text-left">Title</th>
          <th class="px-4 py-3 text-left">Type</th>
          <th class="px-4 py-3 text-left">Audience</th>
          <th class="px-4 py-3 text-left">Price</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($programs as $program)
        <tr class="border-t hover:bg-gray-50">
          <td class="px-4 py-3">
            <div class="font-medium">{{ $program->title }}</div>
            <div class="text-xs text-gray-500">{{ $program->slug }}</div>
          </td>
          <td class="px-4 py-3">
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
              {{ ucfirst($program->product_type) }}
            </span>
          </td>
          <td class="px-4 py-3">
            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs">
              {{ $program->audience_type === 'nurse' ? 'Perawat' : 'Bidan' }}
            </span>
          </td>
          <td class="px-4 py-3">{{ $program->price }}</td>
          <td class="px-4 py-3">
            @if($program->status === 'published')
              <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Published</span>
            @else
              <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Draft</span>
            @endif
          </td>
          <td class="px-4 py-3 text-center">
            <div class="flex justify-center gap-2">
              <a href="{{ route('admin.program-details.edit', $program) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                Edit
              </a>
              <form action="{{ route('admin.program-details.destroy', $program) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                  Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-8 text-center text-gray-500">
            Belum ada program. <a href="{{ route('admin.program-details.create') }}" class="text-blue-600 hover:underline">Tambah program pertama</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $programs->links() }}
  </div>
</div>
@endsection
