<aside id="sidebar"
    class="fixed top-0 left-0 z-40 h-full w-64 bg-gray-800 text-white transition-all duration-300 lg:translate-x-0 -translate-x-full">
    <div class="flex items-center justify-between p-4 border-b border-gray-700">
        <a href="#" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
        </a>
        <button id="sidebarClose" class="lg:hidden text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="overflow-y-auto h-[calc(100%-60px)] p-4 space-y-2">
        <a href="{{ route('dashboard.kwu.index') }}"
            class="flex items-center px-3 py-2 rounded-md
   {{ request()->routeIs('dashboard.kwu.index') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-home w-5"></i>
            <span class="ml-3 sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('dashboard.kwu.toko') }}"
            class="flex items-center px-3 py-2 rounded-md
   {{ request()->routeIs('dashboard.kwu.toko') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-building w-5"></i>
            <span class="ml-3 sidebar-text">Toko</span>
        </a>
        <a href="{{ route('dashboard.kwu.kategori') }}"
            class="flex items-center px-3 py-2 rounded-md
   {{ request()->routeIs('dashboard.kwu.kategori') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-briefcase w-5"></i>
            <span class="ml-3 sidebar-text">Kategori Produk</span>
        </a>
        <a href="{{ route('dashboard.kwu.order') }}"
            class="flex items-center px-3 py-2 rounded-md
   {{ request()->routeIs('dashboard.kwu.order') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-briefcase w-5"></i>
            <span class="ml-3 sidebar-text">Order Produk</span>
        </a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 text-red-500 hover:bg-red-50 transition-all duration-200 rounded-xl">
            <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
            <span class="font-medium">Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>
</aside>
