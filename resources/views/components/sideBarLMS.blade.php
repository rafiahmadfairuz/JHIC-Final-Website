<div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

<div id="mobile-search" class="mobile-search-container">
    <div class="mobile-search-wrapper">
        <input id="mobile-search-input" type="text" placeholder="Cari kursus, tugas, pesan..."
            class="mobile-search-input">
        <i class="fas fa-search mobile-search-icon"></i>
        <button id="mobile-search-close" class="mobile-search-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div id="mobile-search-results" class="mobile-search-results"></div>
</div>

<div id="sidebar"
    class="fixed left-0 top-0 h-full w-64 bg-white shadow-xl z-30 sidebar-transition sidebar-mobile md:translate-x-0">
    <div class="p-4 md:p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="icon" class="w-full h-full object-contain" />
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">LMS</h1>
                    <p class="text-xs text-gray-500 hidden md:block">Learning Management System</p>
                </div>
            </div>
            <button id="close-sidebar" class="md:hidden p-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times w-5 h-5"></i>
            </button>
        </div>
    </div>

    <nav class="mt-4 px-2 md:px-4">
        <a href="{{ route('lms.dashboard') }}"
            class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 rounded-xl transition-all duration-200
            {{ request()->routeIs('lms.dashboard*') ? 'bg-pastel-purple text-purple-main' : 'text-gray-700 hover:bg-pastel-purple hover:text-purple-main' }}">
            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('lms.kursus') }}"
            class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 rounded-xl transition-all duration-200
            {{ request()->routeIs('lms.kursus*') ? 'bg-pastel-purple text-purple-main' : 'text-gray-700 hover:bg-pastel-blue hover:text-blue-main' }}">
            <i class="fas fa-book-open w-5 h-5 mr-3"></i>
            <span class="font-medium">Kursus</span>
        </a>

        <a href="{{ route('lms.nilai') }}"
            class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 rounded-xl transition-all duration-200
            {{ request()->routeIs('lms.nilai*') ? 'bg-pastel-purple text-purple-main' : 'text-gray-700 hover:bg-pastel-blue  hover:text-blue-main' }}">
            <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
            <span class="font-medium">Nilai</span>
        </a>

        <a href="{{ route('lms.profile.cari') }}"
            class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 rounded-xl transition-all duration-200
            {{ request()->routeIs('lms.profile.cari*') ? 'bg-pastel-purple text-purple-main' : 'text-gray-700 hover:bg-pastel-blue  hover:text-blue-main' }}">
            <i class="fas fa-user w-5 h-5 mr-3"></i>
            <span class="font-medium">User</span>
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
    </nav>

    <div class="absolute bottom-4 left-4 right-4 hidden md:block text-center">
        <div class="mb-2">
            <img src="{{ asset('assets/img/about 1.png') }}" alt="icon"
                class="w-16 h-16 md:w-20 md:h-20 mx-auto drop-shadow-md" />
        </div>
        <p class="text-xs md:text-sm text-gray-600 font-medium">
            Keep learning!
        </p>
    </div>
</div>
