<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-[some-integrity-hash]" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-purple': '#F3F0FF',
                        'purple-main': '#8B5CF6',
                        'pastel-blue': '#EFF6FF',
                        'blue-main': '#3B82F6',
                        'pastel-orange': '#FFF7ED',
                        'orange-main': '#F97316'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            box-sizing: border-box;
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .progress-circle {
            background: conic-gradient(#8B5CF6 0deg 252deg, #E5E7EB 252deg 360deg);
        }


        /* Mobile Search Styles */
        .mobile-search-btn {
            display: none;
            padding: 8px;
            color: #6b7280;
            transition: color 0.2s;
        }

        .mobile-search-btn:hover {
            color: #8B5CF6;
        }

        .search-icon {
            width: 20px;
            height: 20px;
        }

        .mobile-search-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 60;
            flex-direction: column;
        }

        .mobile-search-container.active {
            display: flex;
        }

        .mobile-search-wrapper {
            position: relative;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .mobile-search-input {
            width: 100%;
            padding: 12px 48px 12px 40px;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            font-size: 16px;
            outline: none;
            transition: all 0.2s;
        }

        .mobile-search-input:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        .mobile-search-icon {
            position: absolute;
            left: 28px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
        }

        .mobile-search-close {
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            padding: 4px;
            color: #6b7280;
        }

        .mobile-search-close svg {
            width: 20px;
            height: 20px;
        }

        .mobile-search-results {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        .search-result-item {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f9fafb;
        }

        .search-result-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-result-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .search-result-text {
            flex: 1;
        }

        .search-result-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .search-result-desc {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .search-result-badge {
            display: inline-block;
            padding: 2px 8px;
            background-color: #f3f4f6;
            color: #6b7280;
            font-size: 10px;
            border-radius: 9999px;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }

            .sidebar-mobile.open {
                transform: translateX(0);
            }

            .mobile-search-btn {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    @if (session('badge_unlocked'))
        <div id="badge-toast"
            class="fixed bottom-5 right-5 bg-purple-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-bounce z-50">

            @php
                $badge = session('badge_unlocked');
            @endphp


            <div
                class="w-8 h-8 rounded-lg bg-purple-700 flex items-center justify-center text-white text-lg shadow-inner">
                <i class="fas fa-medal"></i>
            </div>


            <div>
                <strong>Badge Baru!</strong><br>
                {{ $badge['nama'] }}
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('badge-toast')?.remove();
            }, 4000);
        </script>
    @endif


    <div class=" min-h-screen">
        <header class="bg-white shadow-sm border-b border-gray-100 px-4 md:px-6 py-4 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu" class="md:hidden p-2 text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 id="page-title" class="text-xl md:text-2xl font-bold text-gray-800">Detail Lamaran
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
        <main id="page-content" class="p-4 md:p-6">
            <div class="p-4 md:p-6 max-w-7xl mx-auto space-y-8">

                {{-- HEADER PROFIL --}}
                @php
                    $kelas = optional($profile->kelas);
                    $kelasName = "{$kelas->tingkat}-{$kelas->jurusan->nama_jurusan}-{$kelas->urutan_kelas}";
                    $gradeDesc =
                        $avgRapotSummary->rata_rata >= 90
                            ? 'Sangat Baik'
                            : ($avgRapotSummary->rata_rata >= 80
                                ? 'Baik'
                                : ($avgRapotSummary->rata_rata >= 70
                                    ? 'Cukup'
                                    : 'Perlu Perbaikan'));
                @endphp

                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-2xl p-6 shadow-md relative">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div
                            class="w-20 h-20 rounded-full bg-white bg-opacity-20 flex items-center justify-center overflow-hidden">
                            @if ($profile->foto)
                                <img src="{{ asset('storage/' . $profile->foto) }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <span
                                    class="text-3xl font-bold">{{ strtoupper(substr($profile->nama_lengkap, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ $profile->nama_lengkap }}</h1>
                            <p class="text-sm opacity-90">{{ $user->email }}</p>
                            <p class="mt-2 text-sm">Kelas: <strong>{{ $kelasName }}</strong></p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="text-sm font-medium">Rata-rata Nilai</p>
                            <p class="text-3xl font-bold">{{ number_format($avgRapotSummary->rata_rata, 1) }}</p>
                            <p class="text-xs opacity-80">Kategori: {{ $gradeDesc }}</p>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK 4 KOTAK --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between mb-2">
                            <i class="fas fa-book-open text-indigo-500"></i>
                            <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full">Akademik</span>
                        </div>
                        <h3 class="font-bold text-gray-800">Rata-rata Rapot</h3>
                        <p class="text-2xl font-bold text-indigo-600">
                            {{ number_format($avgRapotSummary->rata_rata, 1) }}</p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between mb-2">
                            <i class="fas fa-chart-line text-green-500"></i>
                            <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                                {{ $improvement > 0 ? 'Naik' : ($improvement < 0 ? 'Turun' : 'Stabil') }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-800">Produk Terjual</h3>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $totalTerjual }}</p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between mb-2">
                            <i class="fas fa-trophy text-yellow-500"></i>
                            <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">Ranking</span>
                        </div>
                        <h3 class="font-bold text-gray-800">Peringkat</h3>
                        <p class="text-2xl font-bold text-yellow-600">#{{ $rankNumber ?? '-' }}</p>
                        <p class="text-xs text-gray-500">Dari {{ $classTotal ?? '-' }} siswa</p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between mb-2">
                            <i class="fas fa-certificate text-purple-500"></i>
                            <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full">Badge</span>
                        </div>
                        <h3 class="font-bold text-gray-800">Total Badge</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ count($badges) }}</p>
                    </div>
                </div>

                {{-- NILAI + BADGE + RANKING --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- NILAI MAPEL --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 overflow-y-auto"
                        style="max-height: 480px;">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Nilai per Mata Pelajaran</h3>
                        <div class="space-y-3">
                            @forelse($nilaiPerMapel as $n)
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl">
                                    <span class="font-semibold text-gray-700">{{ $n->nama_mapel }}</span>
                                    <div class="text-right">
                                        <span class="font-bold text-indigo-600">{{ $n->nilai }}</span>
                                        <p class="text-xs text-gray-500">{{ $n->grade }} ({{ $n->kategori }})</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada nilai mapel.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- BADGES & RANKING --}}
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-3">Pencapaian Akademik</h3>
                            <div class="space-y-3 h-80">
                                @forelse($badges as $b)
                                    <div class="flex items-center gap-3 p-3 bg-yellow-50 rounded-xl">
                                        <i class="fas fa-medal text-yellow-600"></i>
                                        <div>
                                            <p class="font-semibold text-gray-700">{{ $b['nama'] }}</p>
                                            <p class="text-xs text-gray-500">Kategori: {{ $b['kategori'] }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada badge.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- NILAI MAPEL --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 overflow-y-auto"
                        style="max-height: 480px;">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Berkas yang diupload</h3>
                        <div class="space-y-3">
                            @forelse($listBerkas as $n)
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl">
                                    <button onclick="openPreview('{{ asset('storage/berkas_lamaran/' . $n) }}')"
                                        class="text-blue-600 underline">
                                        {{ Illuminate\Support\Str::limit($n, 50) }}
                                    </button>

                                    <a href="{{ asset('storage/berkas_lamaran/' . $n) }}" download
                                        class="text-sm text-gray-500 hover:text-gray-700">
                                        Download
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada berkas.</p>
                            @endforelse

                        </div>
                    </div>


                    {{-- KANAN: Grafik --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-chart-bar text-gray-600"></i>
                            <h2 class="font-bold text-gray-800">Produk Terjual</h2>
                        </div>
                        <div class="relative h-64 flex justify-center">
                            <canvas id="gradesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById('gradesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Total Terjual',
                            data: @json($chartData),
                            backgroundColor: ['#6366F1', '#F59E0B', '#10B981', '#3B82F6', '#EC4899', '#8B5CF6'],
                            borderColor: '#4B5563',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true,
                                ticks: {
                                    color: '#374151'
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    color: '#374151'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Produk Terjual',
                                color: '#111827',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                });
            </script>

        </main>
    </div>
    <!-- Modal Preview -->
    <div id="previewModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div class="bg-white w-11/12 h-[90vh] rounded-lg shadow relative p-4">

            <!-- Close Btn -->
            <button onclick="closePreview()" class="absolute top-3 right-3 text-gray-700 font-bold">
                ✕
            </button>

            <!-- Viewer -->
            <iframe id="previewFrame" class="w-full h-full rounded"></iframe>

        </div>
    </div>

    <script>
        function openPreview(url) {

            let iframe = document.getElementById('previewFrame');

            // cek extension
            let ext = url.split('.').pop().toLowerCase();

            if (ext === "doc" || ext === "docx" || ext === "ppt" || ext === "pptx" || ext === "xls" || ext === "xlsx") {
                iframe.src = "https://view.officeapps.live.com/op/view.aspx?src=" + encodeURIComponent(url);
            } else {
                iframe.src = url;
            }

            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewFrame').src = "";
        }
        const mobileMenu = document.getElementById('mobile-menu');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        mobileMenu?.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-mobile');
            mobileOverlay.classList.remove('hidden');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('sidebar-mobile');
            mobileOverlay.classList.add('hidden');
        });

        mobileOverlay?.addEventListener('click', () => {
            sidebar.classList.add('sidebar-mobile');
            mobileOverlay.classList.add('hidden');
        });

        function handleSearch(event) {
            const query = event.target.value.toLowerCase().trim();
            const searchResults = document.getElementById('search-results');
            const allItems = document.querySelectorAll('.search-item');

            let visibleCount = 0;
            allItems.forEach(item => {
                const title = item.dataset.title.toLowerCase();
                const text = item.textContent.toLowerCase();
                if (title.includes(query) || text.includes(query)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (query === '' || visibleCount === 0) {
                searchResults.classList.add('hidden');
            } else {
                searchResults.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationBadge = document.getElementById('notification-badge');
            const markAllBtn = notificationDropdown.querySelector('button');

            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });

            function updateBadge() {
                const unreadCount = notificationDropdown.querySelectorAll('a .bg-orange-main').length;
                if (unreadCount === 0) notificationBadge.classList.add('hidden');
                else {
                    notificationBadge.textContent = unreadCount;
                    notificationBadge.classList.remove('hidden');
                }
            }

            markAllBtn.addEventListener('click', () => {
                notificationDropdown.querySelectorAll('a .bg-orange-main').forEach(dot => {
                    dot.classList.remove('bg-orange-main');
                    dot.classList.add('bg-gray-300');
                });
                updateBadge();
            });

            updateBadge();
        });
    </script>
</body>

</html>
