    <header class="bg-white shadow-sm border-b border-gray-100 px-4 md:px-6 py-4 sticky top-0 z-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button id="mobile-menu" class="md:hidden p-2 text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 id="page-title" class="text-xl md:text-2xl font-bold text-gray-800">LMS Siswa SMK Krian 1 Sidoarjo
                </h2>
            </div>
            <div class="flex items-center space-x-2 md:space-x-4">
                <!-- User Profile -->
                <div class="relative">
                    @php
                        $user = Auth::user();
                        $nama = $user->nama_lengkap ?? 'User';
                        $words = explode(' ', trim($nama));
                        $initials = strtoupper(
                            substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                        );
                        $colors = ['purple', 'blue', 'green', 'orange', 'pink', 'teal', 'red', 'indigo'];
                        $color = $colors[crc32($nama) % count($colors)];
                    @endphp

                    <a href="{{ route('lms.profile') }}" id="user-menu-btn"
                        class="flex items-center space-x-2 p-1 rounded-full hover:bg-gray-100 transition-colors">
                        <div
                            class="w-8 h-8 rounded-full bg-{{ $color }}-100 flex items-center justify-center text-{{ $color }}-700 font-bold text-sm">
                            {{ $initials }}
                        </div>
                        <span class="font-medium text-gray-700 hidden md:block">{{ $nama }}</span>

                    </a>


                </div>
            </div>
        </div>
    </header>
