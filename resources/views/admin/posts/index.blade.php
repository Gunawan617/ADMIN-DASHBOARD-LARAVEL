@extends('admin.layout')

@section('content')
<div class="container mx-auto">
  <h1 class="text-3xl font-bold mb-6 text-gray-800">📝 Posts Management</h1>

  <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <a href="{{ route('admin.posts.create') }}" class="inline-block bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition duration-200">
        + Add New Post
    </a>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
      <input 
        type="text" 
        name="search" 
        placeholder="Search posts..." 
        value="{{ request('search') }}"
        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64"
      >
      
      <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">All Status</option>
        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
      </select>

      <select name="category" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>

      <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition duration-200">
        Search
      </button>

      @if(request('search') || request('status') || request('category'))
        <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-md hover:bg-gray-600 transition duration-200">
          Reset
        </a>
      @endif
    </form>
  </div>

  @if(session('success'))
      <x-alert type="success" :message="session('success')" />
  @endif

  <!-- Results Info -->
  <div class="mb-4 text-sm text-gray-600">
    Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts
    @if(request('search'))
      <span class="font-semibold">for "{{ request('search') }}"</span>
    @endif
  </div>

  <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
    <table class="w-full text-left bg-white">

        <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Summary</th>
                <th class="px-4 py-3">Author</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Image</th>
                <th class="px-4 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700">
            @forelse($posts as $post)
                <tr class="border-t border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium max-w-[200px]">
                      <div class="truncate" title="{{ $post->title }}">{{ $post->title }}</div>
                      <div class="text-xs text-gray-500 truncate">{{ $post->slug }}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-600 max-w-[250px] truncate" title="{{ $post->summary }}">{{ $post->summary }}</td>
                    <td class="px-4 py-3">{{ $post->author ?? '-' }}</td>
                    <td class="px-4 py-3">
                      @if($post->category)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $post->category }}</span>
                      @else
                        <span class="text-gray-400">-</span>
                      @endif
                    </td>
                    <td class="px-4 py-3">
                      @if($post->status == 'published')
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Published</span>
                      @elseif($post->status == 'draft')
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Draft</span>
                      @else
                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Archived</span>
                      @endif
                    </td>
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
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
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
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        @if(request('search') || request('status') || request('category'))
                            No posts found matching your search criteria.
                        @else
                            No posts available. Create your first post!
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
