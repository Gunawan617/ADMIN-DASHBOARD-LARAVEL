<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
    }

    .sidebar-item {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar-item:hover {
      transform: translateX(4px);
    }
    .glassmorphism {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .active-menu {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
  </style>
</head>
  <body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <style>
      @media (min-width: 768px) {
        .container {
          padding-top: 8rem !important;
        }
      }
    </style>

    <!-- Desktop Header (Logout pojok kanan atas) -->
  <header class="hidden md:flex fixed top-0 left-0 right-0 h-16 bg-white shadow z-40 items-center justify-end pr-4">
      <div class="relative group">
  <button class="flex items-center gap-3 focus:outline-none bg-transparent p-0 shadow-none hover:bg-transparent">
          <div class="w-9 h-9 rounded-full bg-gradient-to-r from-pink-500 to-violet-500 flex items-center justify-center text-white font-bold">AD</div>
          <span class="text-gray-700 font-medium">Admin User</span>
          <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
  <div class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 pointer-events-none group-hover:pointer-events-auto group-focus-within:pointer-events-auto transition-all z-50">
          <div class="px-4 py-3 border-b border-gray-100">
            <div class="font-semibold text-gray-800">Admin User</div>
            <div class="text-xs text-gray-500">administrator</div>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 bg-transparent hover:bg-red-50 flex items-center gap-2 border-0 shadow-none">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
              Logout
            </button>
          </form>
        </div>
      </div>
    </header>

  <!-- Mobile Header -->
  <header class="md:hidden fixed top-0 left-0 right-0 bg-white shadow p-4 flex justify-between items-center z-50">
    <h1 class="font-bold text-gray-800">Admin Panel</h1>
    <button id="menu-toggle" class="p-2 rounded-md bg-gray-200">
      <!-- Icon hamburger -->
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </header>

  <!-- Sidebar (desktop) -->
  <aside class="fixed left-0 top-0 w-72 h-full gradient-bg shadow-2xl z-40 hidden md:block" style="margin-top: 4rem;">
    <!-- Logo/Header -->
    <div class="p-8 border-b border-white/20">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center glassmorphism">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-white">Admin Panel</h1>
          <p class="text-white/70 text-sm">Management System</p>
        </div>
      </div>
    </div>
    
  <!-- Navigation -->
  <nav class="p-6 space-y-2 pt-2">
      <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white active-menu">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Dashboard</div>
          <div class="text-xs text-white/60">Overview & Analytics</div>
        </div>
      </a>
      
      <a href="{{ route('admin.posts.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Posts</div>
          <div class="text-xs text-white/60">Manage content</div>
        </div>
      </a>

      <a href="{{ route('admin.books.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 006.5 22h11a2.5 2.5 0 002.5-2.5v-15A2.5 2.5 0 0017.5 2h-11A2.5 2.5 0 004 4.5v15zM8 6h8M8 10h8m-8 4h6"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Buku</div>
          <div class="text-xs text-white/60">Manajemen buku</div>
        </div>
      </a>

      <a href="{{ route('admin.team-members.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0 0V8a4 4 0 118 0v6m-8 0h8"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Team Members</div>
          <div class="text-xs text-white/60">Manage team</div>
        </div>
      </a>

      <a href="{{ route('admin.tryout-programs.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Tryout</div>
          <div class="text-xs text-white/60">Manage tryouts</div>
        </div>
      </a>

      <a href="{{ route('admin.bimbel-programs.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Bimbel</div>
          <div class="text-xs text-white/60">Manage Bimbel Programs</div>
        </div>
      </a>

      <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Users</div>
          <div class="text-xs text-white/60">User management</div>
        </div>
      </a>
      
      <!-- Logout tetap di sidebar untuk mobile/akses alternatif -->
      <div class="pt-6 md:hidden">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="sidebar-item flex items-center p-4 rounded-xl text-red-300 hover:bg-red-500/10 hover:text-red-200 w-full">
            <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
            </div>
            <div>
              <div class="font-medium">Logout</div>
              <div class="text-xs text-red-300/60">Sign out</div>
            </div>
          </button>
        </form>
      </div>
    </nav>
    
    <!-- User Profile di bawah sidebar dihapus. Untuk tampilan modern, letakkan user profile/avatar di pojok kanan atas header (desktop), dan di menu mobile (dropdown/hamburger). -->
    <!-- Saran: Tambahkan avatar/user info di header kanan atas, misal:
    <div class="hidden md:flex items-center gap-3 absolute right-24 top-4">
      <div class="w-9 h-9 rounded-full bg-gradient-to-r from-pink-500 to-violet-500 flex items-center justify-center text-white font-bold">AD</div>
      <span class="text-gray-700 font-medium">Admin User</span>
    </div>
    -->
    <!-- User info kecil di bawah sidebar desktop -->
    <div class="absolute bottom-0 left-0 right-0 p-2 border-t border-white/10 flex items-center gap-1 bg-gradient-to-r from-indigo-500/10 to-blue-500/10 md:flex hidden">
      <div class="w-6 h-6 rounded-full bg-gradient-to-r from-pink-500 to-violet-500 flex items-center justify-center text-[10px] text-white font-bold">AD</div>
      <span class="text-white/80 text-[11px] font-medium">Admin User</span>
    </div>
    <!-- Logout di bawah sidebar desktop -->
    <div class="absolute bottom-0 left-0 right-0 pb-1 flex justify-center md:flex hidden" style="transform: translateY(-28px);">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center gap-1 px-2 py-1 text-xs text-red-400 hover:text-red-600 bg-transparent rounded focus:outline-none">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          </svg>
          Logout
        </button>
      </form>
    </div>
  </aside>

  <!-- Sidebar (mobile, copy dari desktop) -->
  <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 h-full gradient-bg shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 md:hidden">
    <div class="p-8 border-b border-white/20">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center glassmorphism">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-white">Admin Panel</h1>
          <p class="text-white/70 text-sm">Management System</p>
        </div>
      </div>
    </div>
    <nav class="p-6 space-y-2">
      <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white active-menu">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Dashboard</div>
          <div class="text-xs text-white/60">Overview & Analytics</div>
        </div>
      </a>
      <a href="{{ route('admin.posts.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Posts</div>
          <div class="text-xs text-white/60">Manage content</div>
        </div>
      </a>
      <a href="{{ route('admin.books.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 006.5 22h11a2.5 2.5 0 002.5-2.5v-15A2.5 2.5 0 0017.5 2h-11A2.5 2.5 0 004 4.5v15zM8 6h8M8 10h8m-8 4h6"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Buku</div>
          <div class="text-xs text-white/60">Manajemen buku</div>
        </div>
      </a>
      <a href="{{ route('admin.team-members.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0 0V8a4 4 0 118 0v6m-8 0h8"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Team Members</div>
          <div class="text-xs text-white/60">Manage team</div>
        </div>
      </a>
      <a href="{{ route('admin.tryout-programs.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Tryout</div>
          <div class="text-xs text-white/60">Manage tryouts</div>
        </div>
      </a>
      <a href="{{ route('admin.bimbel-programs.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Bimbel</div>
          <div class="text-xs text-white/60">Manage Bimbel Programs</div>
        </div>
      </a>
      <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center p-4 rounded-xl text-white/90 hover:bg-white/10 hover:text-white">
        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium">Users</div>
          <div class="text-xs text-white/60">User management</div>
        </div>
      </a>
  <!-- Logout di bawah sidebar mobile dihapus, sudah pindah ke atas -->
    </nav>
  <!-- Bagian user profile bawah sidebar mobile dihapus agar tidak dobel dan lebih rapi -->
  <!-- User info di bawah sidebar mobile dihapus agar lebih rapi -->
  <!-- Logout di bawah sidebar mobile dihapus agar tidak ada tulisan logout sama sekali di mobile -->
  </aside>


  
  
  <!-- Main Content -->
  <main class="p-8 pt-20 md:pt-8 md:ml-72">
    @yield('content')
    @stack('scripts')
  </main>

  <!-- JS toggle -->
  <script>
    const btn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('mobile-sidebar');
    btn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>

</body>
</html>
