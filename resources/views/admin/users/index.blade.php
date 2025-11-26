@extends('admin.layout')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">👥 User Management</h1>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <input 
                type="text" 
                name="search" 
                placeholder="Search name or email..." 
                value="{{ request('search') }}"
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64"
            >
            
            <select name="role" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Roles</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition duration-200">
                Search
            </button>

            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                    Reset
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Results Info -->
    <div class="mb-4 text-sm text-gray-600">
        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
        @if(request('search'))
            <span class="font-semibold">for "{{ request('search') }}"</span>
        @endif
    </div>

    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
        <table class="w-full text-left bg-white">
            <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Registered</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($users as $user)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $user->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $user->name }}</div>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-blue-600">(You)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded font-semibold">Admin</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit Role
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="bg-gray-300 text-gray-500 px-3 py-1 rounded text-xs cursor-not-allowed" title="Cannot delete yourself">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            @if(request('search') || request('role'))
                                No users found matching your search criteria.
                            @else
                                No users available.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
