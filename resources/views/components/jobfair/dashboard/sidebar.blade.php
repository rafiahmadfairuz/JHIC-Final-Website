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
        <a href="{{ route('dashboard.jobfair.index') }}"
            class="flex items-center px-3 py-2 rounded-md
       {{ request()->routeIs('dashboard.jobfair.index') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-home w-5"></i>
            <span class="ml-3 sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('dashboard.jobfair.perusahaan') }}"
            class="flex items-center px-3 py-2 rounded-md
       {{ request()->routeIs('dashboard.jobfair.perusahaan*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-building w-5"></i>
            <span class="ml-3 sidebar-text">Perusahaan</span>
        </a>
        <a href="{{ route('dashboard.jobfair.pekerjaan') }}"
            class="flex items-center px-3 py-2 rounded-md
       {{ request()->routeIs('dashboard.jobfair.pekerjaan*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-briefcase w-5"></i>
            <span class="ml-3 sidebar-text">Pekerjaan</span>
        </a>
        <a href="{{ route('dashboard.jobfair.lamaran') }}"
            class="flex items-center px-3 py-2 rounded-md
       {{ request()->routeIs('dashboard.jobfair.lamaran*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            <i class="fas fa-file-alt w-5"></i>
            <span class="ml-3 sidebar-text">Lamaran Kerja</span>
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
