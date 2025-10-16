<nav
    class="backdrop-blur-md bg-white container shadow-lg mx-auto px-2 sm:px-4 py-2 sm:py-3 rounded-full sticky top-2 sm:top-4 z-50">
    <div class="flex flex-row items-center justify-between gap-2 sm:gap-4">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10" />
        </div>
        <form action="{{ route('jobfair.landing') }}" method="GET"
            class="flex items-center flex-1 bg-gray-50/70 px-2 sm:px-3 py-1 sm:py-2 rounded-full border
             focus-within:ring-2 focus-within:ring-blue-400 transition shadow-sm max-w-full sm:max-w-2xl">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-2 flex items-center text-gray-400 text-sm sm:text-base">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pekerjaan..."
                    class="pl-8 sm:pl-10 pr-2 sm:pr-4 py-1 sm:py-2 bg-transparent w-full text-xs sm:text-sm focus:outline-none text-gray-700 placeholder-gray-400" />
            </div>
            <button type="submit"
                class="ml-1 sm:ml-2 px-2 sm:px-4 py-1 sm:py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-xs sm:text-sm font-medium
               hover:from-blue-600 hover:to-blue-700 transition shadow-md whitespace-nowrap">
                Cari
            </button>
        </form>
        @if (auth()->check() && auth()->user()->profile)
            <div class="relative" id="userDropdownWrapper">
                <!-- Tombol Profile -->
                <button id="userDropdownButton" onclick="toggleDropdown()"
                    class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100 transition text-gray-700 shadow-sm">
                    @php
                        $namaLengkap = auth()->user()->profile->nama_lengkap ?? auth()->user()->name;
                        $inisial = strtoupper(substr($namaLengkap, 0, 1));
                        $foto = auth()->user()->profile->foto ?? null;
                    @endphp

                    @if ($foto)
                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto Profil"
                            class="w-8 h-8 rounded-full object-cover border shadow-sm" />
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-semibold text-sm shadow-sm border">
                            {{ $inisial }}
                        </div>
                    @endif

                    <span class="hidden sm:inline font-medium text-sm">{{ $namaLengkap }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userDropdown"
                    class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-lg py-2 z-50">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5 mr-2"></i>
                        <span class="font-medium">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <script>
                // Toggle dropdown
                function toggleDropdown() {
                    const dropdown = document.getElementById('userDropdown');
                    dropdown.classList.toggle('hidden');
                }

                // Tutup dropdown saat klik di luar
                document.addEventListener('click', function(event) {
                    const wrapper = document.getElementById('userDropdownWrapper');
                    const dropdown = document.getElementById('userDropdown');
                    if (!wrapper.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            </script>
        @else
            {{-- <a href="{{ route('login') }}" --}}
            <a
                class="px-3 sm:px-4 py-1 sm:py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs sm:text-sm rounded-full
               hover:from-blue-600 hover:to-blue-700 transition font-medium shadow-md">
                Login
            </a>
        @endif
    </div>
</nav>
