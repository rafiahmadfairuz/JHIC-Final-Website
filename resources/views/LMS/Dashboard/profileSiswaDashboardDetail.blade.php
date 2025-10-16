<x-baseLMSDashboard>
    <div class="p-4 md:p-6 max-w-7xl mx-auto space-y-8">

        {{-- HEADER PROFIL --}}
        @php
            $kelas = optional($profile->kelas);
            $kelasName = "{$kelas->tingkat}-{$kelas->jurusan->nama_jurusan}-{$kelas->urutan_kelas}";
            $gradeDesc =
                $avgRapot >= 90
                    ? 'Sangat Baik'
                    : ($avgRapot >= 80
                        ? 'Baik'
                        : ($avgRapot >= 70
                            ? 'Cukup'
                            : 'Perlu Perbaikan'));
        @endphp

        <div class="bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-2xl p-6 shadow-md relative">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <div
                    class="w-20 h-20 rounded-full bg-white bg-opacity-20 flex items-center justify-center overflow-hidden">
                    @if ($profile->foto)
                        <img src="{{ asset('storage/' . $profile->foto) }}" class="w-full h-full object-cover" />
                    @else
                        <span class="text-3xl font-bold">{{ strtoupper(substr($profile->nama_lengkap, 0, 1)) }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ $profile->nama_lengkap }}</h1>
                    <p class="text-sm opacity-90">{{ $user->email }}</p>
                    <p class="mt-2 text-sm">Kelas: <strong>{{ $kelasName }}</strong></p>
                </div>
                <div class="ml-auto text-right">
                    <p class="text-sm font-medium">Rata-rata Nilai</p>
                    <p class="text-3xl font-bold">{{ number_format($avgRapot, 1) }}</p>
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
                <p class="text-2xl font-bold text-indigo-600">{{ number_format($avgRapot, 1) }}</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between mb-2">
                    <i class="fas fa-chart-line text-green-500"></i>
                    <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                        {{ $improvement > 0 ? 'Naik' : ($improvement < 0 ? 'Turun' : 'Stabil') }}
                    </span>
                </div>
                <h3 class="font-bold text-gray-800">Perkembangan</h3>
                <p class="text-2xl font-bold text-green-600">
                    {{ $improvement > 0 ? '+' : '' }}{{ number_format($improvement, 1) }}</p>
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

        <div id="track" class="content-section">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                        Track Record {{ $user->name }}
                    </h3>
                    <button id="btn-tambah"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-plus mr-2"></i> Tambah Record
                    </button>
                </div>

                <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Track Record</h4>
                    <form id="formTrack" method="POST">
                        @csrf
                        <input type="hidden" id="form_method" name="_method" value="POST">
                        <input type="hidden" name="siswa_id" value="{{ $user->id }}">
                        <input type="hidden" id="record_id" name="id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Guru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                    </div>
                                    <select name="guru_id" id="guru_id"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Pilih Guru</option>
                                        @foreach ($gurus as $g)
                                            <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('guru_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="tanggal" id="tanggal"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                @error('tanggal')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <i class="fas fa-sticky-note text-gray-400"></i>
                                    </div>
                                    <textarea name="catatan" id="catatan" rows="4"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Tulis catatan perilaku siswa..."></textarea>
                                </div>
                                @error('catatan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                    <i class="fas fa-save mr-2"></i> <span id="btn-submit-text">Simpan Record</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guru</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catatan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($trackRecords as $t)
                                <tr>
                                    <td class="px-6 py-4 text-sm">{{ $t->id }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $t->guru->nama_lengkap ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $t->tanggal }}</td>
                                    <td class="px-6 py-4 text-sm max-w-xs truncate">{{ $t->catatan }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                            data-id="{{ $t->id }}" data-guru="{{ $t->guru_id }}"
                                            data-tanggal="{{ $t->tanggal }}" data-catatan="{{ $t->catatan }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 btn-delete"
                                            data-id="{{ $t->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $trackRecords->links('pagination::tailwind') }}</div>
            </div>
        </div>

        <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-60 z-50">
            <div class="absolute top-1/2 left-1/2 w-[90%] max-w-sm bg-white rounded-xl p-6 shadow-lg text-center"
                style="transform: translate(-50%, -50%);">
                <h2 class="text-lg font-semibold mb-4">Yakin ingin menghapus data ini?</h2>
                <div class="mt-4">
                    <button id="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded-lg mx-2">Hapus</button>
                    <button id="cancelDelete" class="bg-gray-300 px-4 py-2 rounded-lg mx-2">Batal</button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div id="successModal"
                class="fixed bottom-5 right-5 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>{{ session('success') }}</div>
            </div>
            <script>
                setTimeout(() => document.getElementById('successModal')?.remove(), 4000)
            </script>
        @endif
        @if (session('error'))
            <div id="errorModal"
                class="fixed bottom-5 right-5 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
                <i class="fas fa-times-circle text-2xl"></i>
                <div>{{ session('error') }}</div>
            </div>
            <script>
                setTimeout(() => document.getElementById('errorModal')?.remove(), 4000)
            </script>
        @endif

        <script>
            document.getElementById('btn-tambah').addEventListener('click', () => {
                const formContainer = document.getElementById('form-container');
                formContainer.classList.toggle('hidden');
                document.getElementById('formTrack').reset();
                document.getElementById('form_method').value = 'POST';
                document.getElementById('formTrack').action = "{{ route('trackRecord.store') }}";
                document.getElementById('btn-submit-text').textContent = 'Simpan Record';
            });

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('form-container').classList.remove('hidden');
                    document.getElementById('formTrack').reset();
                    document.getElementById('record_id').value = btn.dataset.id;
                    document.getElementById('guru_id').value = btn.dataset.guru;
                    document.getElementById('tanggal').value = btn.dataset.tanggal;
                    document.getElementById('catatan').value = btn.dataset.catatan;
                    document.getElementById('form_method').value = 'PUT';
                    document.getElementById('formTrack').action = '/lms/dashboard/trackRecord/' + btn.dataset
                    .id;
                    document.getElementById('btn-submit-text').textContent = 'Update Record';
                });
            });

            let deleteId = null;
            document.querySelectorAll('.btn-delete').forEach(btn => btn.onclick = () => {
                deleteId = btn.dataset.id;
                document.getElementById('deleteModal').classList.remove('hidden');
            });
            document.getElementById('cancelDelete').onclick = () => document.getElementById('deleteModal').classList.add(
                'hidden');
            document.getElementById('confirmDelete').onclick = () => {
                fetch(`/lms/dashboard/trackRecord/${deleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => location.reload());
            };
        </script>

        {{-- GRID UTAMA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- KIRI: Kursus --}}
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 overflow-y-auto"
                style="max-height: 480px;">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kursus Aktif</h2>
                <div class="space-y-4">
                    @forelse($kursuses as $kursus)
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 {{ $kursus['warna'] }} rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-base"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $kursus['nama'] }}</h4>
                                    <p class="text-xs text-gray-500">{{ $kursus['mapel'] }} • {{ $kursus['guru'] }}
                                    </p>
                                    <div class="w-32 bg-gray-200 h-2 rounded-full mt-1">
                                        <div class="h-2 bg-indigo-500 rounded-full"
                                            style="width: {{ $kursus['progress'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-600">{{ $kursus['progress'] }}%</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada kursus untuk kelas ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- KANAN: Grafik --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-chart-bar text-gray-600"></i>
                    <h2 class="font-bold text-gray-800">Distribusi Nilai</h2>
                </div>
                <div class="relative h-64 flex justify-center">
                    <canvas id="gradesChart"></canvas>
                </div>
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
                    <div class="space-y-3">
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

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-3">Top 3 Ranking Kelas</h3>
                    <div class="space-y-2">
                        @forelse($topRanking as $t)
                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                                <p class="font-medium text-gray-700">{{ $t->nama_lengkap }}</p>
                                <span class="text-indigo-600 font-bold">#{{ $t->rank }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data ranking.</p>
                        @endforelse
                    </div>
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
                    label: 'Nilai',
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
                        max: 100,
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
                        text: 'Distribusi Nilai Siswa',
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
</x-baseLMSDashboard>
