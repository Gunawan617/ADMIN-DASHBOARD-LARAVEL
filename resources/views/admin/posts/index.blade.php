@extends('admin.layout')

@section('content')
<div class="container mx-auto">
  <h1 class="text-3xl font-bold mb-6 text-gray-800">📝 Posts Management</h1>

  <a href="{{ route('admin.posts.create') }}" class="inline-block bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition duration-200 mb-4">
      + Add New Post
  </a>

  @if(session('success'))
      <x-alert type="success" :message="session('success')" />
  @endif

  <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
    <table class="w-full text-left bg-white">

        <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Slug</th>
                <th class="px-4 py-3">Summary</th>
                <th class="px-4 py-3">Author</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Image</th>
                <th class="px-4 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700">
            @foreach($posts as $post)
                <tr class="border-t border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium max-w-[180px] truncate">{{ $post->title }}</td>
                    <td class="px-4 py-3 text-gray-600 max-w-[120px] truncate">{{ $post->slug }}</td>
                    <td class="px-4 py-3 text-gray-600 max-w-[200px] truncate">{{ $post->summary }}</td>
                    <td class="px-4 py-3">{{ $post->author }}</td>
                    <td class="px-4 py-3">{{ $post->category }}</td>
                    <td class="px-4 py-3">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-xs text-gray-400 italic">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
