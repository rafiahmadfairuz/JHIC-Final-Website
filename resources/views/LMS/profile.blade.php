<x-baseLMS>
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- HEADER -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Kiri -->
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center overflow-hidden">
                        @if ($profile->foto)
                            <img src="{{ asset('storage/' . $profile->foto) }}" alt="Profil"
                                class="w-full h-full object-cover" />
                        @else
                            <span
                                class="text-white text-xl font-bold">{{ strtoupper(substr($profile->nama_lengkap, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Halo, {{ $profile->nama_lengkap }}!</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="flex gap-4">
                    <div class="bg-indigo-50 rounded-xl p-4 flex items-center gap-3 min-w-[160px]">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-indigo-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ $kursusSelesai }}/{{ $totalKursus }}</div>
                            <div class="text-sm text-gray-600">Kursus Selesai</div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-4 flex items-center gap-3 min-w-[160px]">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-award text-yellow-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">#{{ $peringkatUser }}</div>
                            <div class="text-sm text-gray-600">Dari {{ $totalSiswa }} siswa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PENCAKAPAIAN -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Pencapaian</h2>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-2">
                @forelse($badges as $b)
                    <div class="flex-shrink-0 bg-yellow-50 rounded-xl p-4 text-center min-w-[120px]">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-award text-yellow-600 text-xl"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-800">{{ $b['nama'] }}</div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada pencapaian.</p>
                @endforelse
            </div>
        </div>


        <!-- GRID UTAMA 60:40 -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- KURSUS (60%) -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-md p-6 h-full flex flex-col">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Kursus Saya</h2>

                    <div class="space-y-4 overflow-y-auto pr-2" style="max-height: 500px;">
                        @forelse($kursuses as $kursus)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 {{ $kursus['warna'] }} rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $kursus['nama'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $kursus['mapel'] }} •
                                            {{ $kursus['guru'] }}</p>
                                        <div class="w-40 bg-gray-200 rounded-full h-2 mt-2">
                                            <div class="h-2 rounded-full bg-indigo-500"
                                                style="width: {{ $kursus['progress'] }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $kursus['progress'] }}% selesai</p>
                                    </div>
                                </div>
                                <a href="{{ route('lms.kursus.show', $kursus['id']) }}"
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                                    <i class="fas fa-play text-sm"></i> Lihat Detail
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada kursus untuk kelas Anda.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- DISTRIBUSI NILAI (40%) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6 h-full">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fas fa-chart-bar text-gray-600 text-lg"></i>
                        <h2 class="text-xl font-bold text-gray-800">Distribusi Nilai</h2>
                    </div>
                    <div class="relative h-64 flex items-center justify-center">
                        <canvas id="gradesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('gradesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // ubah ke 'line' jika mau line chart
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Nilai Mata Pelajaran',
                    data: @json($chartData),
                    backgroundColor: [
                        '#6366F1', '#F59E0B', '#10B981', '#3B82F6', '#EC4899', '#8B5CF6'
                    ],
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
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Grafik Nilai Siswa ',
                        color: '#111827',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.label}: ${context.parsed.y}`
                        }
                    }
                }
            }
        });
    </script>
</x-baseLMS>
