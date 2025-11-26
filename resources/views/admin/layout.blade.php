<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Panel</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    * {
      font-family: 'Inter', sans-serif;
    }

    body {
      font-family: 'Inter', sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .sidebar-item {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }
    
    .sidebar-item:hover {
      transform: translateX(2px);
    }
    
    .glassmorphism {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
    }
    
    .gradient-bg::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .active-menu {
      background: rgba(255, 255, 255, 0.2) !important;
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
      border-left: 3px solid white;
    }

    .dropdown-menu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dropdown-menu.open {
      max-height: 500px;
    }
    
    .dropdown-menu a {
      cursor: pointer;
      position: relative;
      z-index: 1;
    }
    
    .dropdown-arrow {
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dropdown-arrow.rotate {
      transform: rotate(180deg);
    }
    
    button.sidebar-item {
      cursor: pointer;
      text-align: left;
    }
    
    .card-modern {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
    }
    
    .card-modern:hover {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transform: translateY(-2px);
    }
    
    /* Scrollbar styling */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.5);
    }
    
    /* Smooth page transitions */
    main {
      animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
  <body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <style>
      @media (min-width: 768px) {
        .container {
          padding-top: 8rem !important;
        }
      }
    </style>

    <!-- Desktop Header (Logout pojok kanan atas) -->
  <header class="hidden md:flex fixed top-0 left-0 right-0 h-16 bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-100 z-40 items-center justify-end pr-6">
      <div class="relative group">
  <button class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200 focus:outline-none bg-transparent shadow-none">
          <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">AD</div>
          <span class="text-gray-700 font-semibold">Admin User</span>
          <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
  <div class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 pointer-events-none group-hover:pointer-events-auto group-focus-within:pointer-events-auto transition-all duration-200 z-50 overflow-hidden">
          <div class="px-4 py-4 bg-gradient-to-br from-indigo-50 to-purple-50 border-b border-gray-100">
            <div class="font-bold text-gray-800">Admin User</div>
            <div class="text-xs text-gray-600 mt-0.5">administrator</div>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="block p-2">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 bg-transparent hover:bg-red-50 rounded-xl flex items-center gap-3 border-0 shadow-none transition-all duration-200 font-medium">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
              Logout
            </button>
          </form>
        </div>
      </div>
    </header>

  <!-- Mobile Header -->
  <header class="md:hidden fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-100 p-4 flex justify-between items-center z-50">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-lg flex items-center justify-center shadow-lg">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
      </div>
      <h1 class="font-bold text-gray-800 text-lg">Admin Panel</h1>
    </div>
    <button id="menu-toggle" class="p-2 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition-all duration-200">
      <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </header>

  <!-- Sidebar (desktop) -->
  <aside class="fixed left-0 top-0 w-72 h-full gradient-bg shadow-2xl z-40 hidden md:block overflow-y-auto" style="margin-top: 4rem;">
    <!-- Logo/Header -->
    <div class="p-6 border-b border-white/20 bg-white/5">
      <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center glassmorphism shadow-lg">
          <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-white tracking-tight">Admin Panel</h1>
          <p class="text-white/70 text-xs font-medium">Management System</p>
        </div>
      </div>
    </div>
    
  <!-- Navigation -->
  <nav class="p-4 space-y-1.5 pt-4 pb-20">
      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-3 rounded-xl text-white/90 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }} group">
        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-sm">Dashboard</div>
          <div class="text-[10px] text-white/60">Overview & Analytics</div>
        </div>
      </a>
      
      <!-- Content Management Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('content')" class="sidebar-item flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 hover:text-white w-full group">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-sm">Content</div>
              <div class="text-[10px] text-white/60">Manage content</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="content-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-12 space-y-0.5 mt-1.5" id="content-menu">
          <a href="{{ route('admin.posts.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.posts.*') ? 'bg-white/10 font-medium' : '' }}">Posts</a>
          <a href="{{ route('admin.books.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-white/10 font-medium' : '' }}">Buku</a>
          <a href="{{ route('admin.program-news.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.program-news.*') ? 'bg-white/10 font-medium' : '' }}">Program News</a>
          <a href="{{ route('admin.faqs.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.faqs.*') ? 'bg-white/10 font-medium' : '' }}">FAQ</a>
        </div>
      </div>

      <!-- User Management Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('users')" class="sidebar-item flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 hover:text-white w-full group">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-sm">Users</div>
              <div class="text-[10px] text-white/60">User management</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="users-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-12 space-y-0.5 mt-1.5" id="users-menu">
          <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 font-medium' : '' }}">Users</a>
          <a href="{{ route('admin.alumni.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.alumni.*') ? 'bg-white/10 font-medium' : '' }}">Alumni</a>
          <a href="{{ route('admin.team-members.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.team-members.*') ? 'bg-white/10 font-medium' : '' }}">Team Members</a>
        </div>
      </div>

      <!-- Homepage Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('homepage')" class="sidebar-item flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 hover:text-white w-full group">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-sm">Homepage</div>
              <div class="text-[10px] text-white/60">Homepage sections</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="homepage-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-12 space-y-0.5 mt-1.5" id="homepage-menu">
          <a href="{{ route('admin.hero-sections.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.hero-sections.*') ? 'bg-white/10 font-medium' : '' }}">Hero Section</a>
          <a href="{{ route('admin.video-sections.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.video-sections.*') ? 'bg-white/10 font-medium' : '' }}">Video Section</a>
        </div>
      </div>

      <!-- Forms & Feedback Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('forms')" class="sidebar-item flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 hover:text-white w-full group">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-sm">Forms & Feedback</div>
              <div class="text-[10px] text-white/60">Forms & testimonials</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="forms-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-12 space-y-0.5 mt-1.5" id="forms-menu">
          <a href="{{ route('admin.formulir.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.formulir.*') ? 'bg-white/10 font-medium' : '' }}">Formulir</a>
          <a href="{{ route('admin.contacts.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.contacts.*') ? 'bg-white/10 font-medium' : '' }}">Pesan Kontak</a>
          <a href="{{ route('admin.testimonials.index') }}" class="block px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-white/10 font-medium' : '' }}">Testimonials</a>
        </div>
      </div>
      
      
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
      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-3 rounded-lg text-white/90 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
        <div class="w-8 h-8 bg-white/10 rounded flex items-center justify-center mr-3">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
          </svg>
        </div>
        <div>
          <div class="font-medium text-sm">Dashboard</div>
          <div class="text-[10px] text-white/60">Overview & Analytics</div>
        </div>
      </a>
      
      <!-- Content Management Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('content-mobile')" class="sidebar-item flex items-center justify-between p-3 rounded-lg text-white/90 hover:bg-white/10 hover:text-white w-full">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-white/10 rounded flex items-center justify-center mr-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
              </svg>
            </div>
            <div>
              <div class="font-medium text-sm">Content</div>
              <div class="text-[10px] text-white/60">Manage content</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="content-mobile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-11 space-y-1 mt-1" id="content-mobile-menu">
          <a href="{{ route('admin.posts.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.posts.*') ? 'bg-white/10' : '' }}">Posts</a>
          <a href="{{ route('admin.books.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.books.*') ? 'bg-white/10' : '' }}">Buku</a>
          <a href="{{ route('admin.program-news.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.program-news.*') ? 'bg-white/10' : '' }}">Program News</a>
        </div>
      </div>

      <!-- User Management Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('users-mobile')" class="sidebar-item flex items-center justify-between p-3 rounded-lg text-white/90 hover:bg-white/10 hover:text-white w-full">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-white/10 rounded flex items-center justify-center mr-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
              </svg>
            </div>
            <div>
              <div class="font-medium text-sm">Users</div>
              <div class="text-[10px] text-white/60">User management</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="users-mobile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-11 space-y-1 mt-1" id="users-mobile-menu">
          <a href="{{ route('admin.users.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.users.*') ? 'bg-white/10' : '' }}">Users</a>
          <a href="{{ route('admin.alumni.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.alumni.*') ? 'bg-white/10' : '' }}">Alumni</a>
          <a href="{{ route('admin.team-members.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.team-members.*') ? 'bg-white/10' : '' }}">Team Members</a>
        </div>
      </div>

      <!-- Homepage Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('homepage-mobile')" class="sidebar-item flex items-center justify-between p-3 rounded-lg text-white/90 hover:bg-white/10 hover:text-white w-full">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-white/10 rounded flex items-center justify-center mr-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <div>
              <div class="font-medium text-sm">Homepage</div>
              <div class="text-[10px] text-white/60">Homepage sections</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="homepage-mobile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-11 space-y-1 mt-1" id="homepage-mobile-menu">
          <a href="{{ route('admin.hero-sections.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.hero-sections.*') ? 'bg-white/10' : '' }}">Hero Section</a>
          <a href="{{ route('admin.video-sections.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.video-sections.*') ? 'bg-white/10' : '' }}">Video Section</a>
        </div>
      </div>

      <!-- Forms & Feedback Dropdown -->
      <div class="dropdown-container">
        <button onclick="toggleDropdown('forms-mobile')" class="sidebar-item flex items-center justify-between p-3 rounded-lg text-white/90 hover:bg-white/10 hover:text-white w-full">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-white/10 rounded flex items-center justify-center mr-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div>
              <div class="font-medium text-sm">Forms & Feedback</div>
              <div class="text-[10px] text-white/60">Forms & testimonials</div>
            </div>
          </div>
          <svg class="w-4 h-4 dropdown-arrow" id="forms-mobile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="dropdown-menu pl-11 space-y-1 mt-1" id="forms-mobile-menu">
          <a href="{{ route('admin.formulir.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.formulir.*') ? 'bg-white/10' : '' }}">Formulir</a>
          <a href="{{ route('admin.testimonials.index') }}" class="block p-2 rounded text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.testimonials.*') ? 'bg-white/10' : '' }}">Testimonials</a>
        </div>
      </div>

      <!-- Logout untuk mobile -->
      <div class="pt-4">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="sidebar-item flex items-center p-3 rounded-lg text-red-300 hover:bg-red-500/10 hover:text-red-200 w-full">
            <div class="w-8 h-8 bg-red-500/10 rounded flex items-center justify-center mr-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
            </div>
            <div>
              <div class="font-medium text-sm">Logout</div>
              <div class="text-[10px] text-red-300/60">Sign out</div>
            </div>
          </button>
        </form>
      </div>
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

    // Dropdown toggle function
    function toggleDropdown(id) {
      const menu = document.getElementById(id + '-menu');
      const arrow = document.getElementById(id + '-arrow');
      menu.classList.toggle('open');
      arrow.classList.toggle('rotate');
    }

    // Auto-open dropdown if current page is in that section
    document.addEventListener('DOMContentLoaded', function() {
      const dropdowns = ['content', 'users', 'homepage', 'forms'];
      dropdowns.forEach(id => {
        // Desktop
        const menu = document.getElementById(id + '-menu');
        const arrow = document.getElementById(id + '-arrow');
        if (menu && arrow) {
          const activeLink = menu.querySelector('.bg-white\\/10');
          if (activeLink) {
            menu.classList.add('open');
            arrow.classList.add('rotate');
          }
        }
        
        // Mobile
        const menuMobile = document.getElementById(id + '-mobile-menu');
        const arrowMobile = document.getElementById(id + '-mobile-arrow');
        if (menuMobile && arrowMobile) {
          const activeLinkMobile = menuMobile.querySelector('.bg-white\\/10');
          if (activeLinkMobile) {
            menuMobile.classList.add('open');
            arrowMobile.classList.add('rotate');
          }
        }
      });
    });
  </script>

</body>
</html>
