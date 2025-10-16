<x-baseLMS>
    <div class="p-4 md:p-6">
        {{-- Banner Siswa Teratas --}}
        @php
            // Hitung keterangan rata‑rata untuk banner
            $gradeDesc = '';
            if ($avgNilai >= 90) {
                $gradeDesc = 'Sangat Baik';
            } elseif ($avgNilai >= 80) {
                $gradeDesc = 'Baik';
            } elseif ($avgNilai >= 70) {
                $gradeDesc = 'Cukup';
            } else {
                $gradeDesc = 'Perlu Perbaikan';
            }
            $kelasName = optional(auth()->user()->profile->kelas)->tingkat  . '-' . optional(auth()->user()->profile->kelas)->jurusan->nama_jurusan . '-' . optional(auth()->user()->profile->kelas)->urutan_kelas;
        @endphp
        <div class="mb-6 bg-gradient-to-r from-blue-700 via-blue-400 to-blue-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-20">
                <i class="fas fa-award h-28 w-28 text-white"></i>
            </div>
            <div class="relative">
                <div class="flex items-center space-x-3 mb-3">
                    <i class="fas fa-trophy text-yellow-300 text-2xl"></i>
                    <h2 class="text-xl md:text-2xl font-bold">Siswa Teratas Kelas!</h2>
                </div>
                @if($rankNumber)
                    <p class="text-yellow-100 mb-2">Selamat! Kamu saat ini peringkat #{{ $rankNumber }} di {{ $kelasName }}</p>
                @else
                    <p class="text-yellow-100 mb-2">Belum ada data nilai untuk menentukan peringkat.</p>
                @endif
                <div class="flex items-center space-x-4 text-sm">
                    <div class="flex items-center space-x-1">
                        <span class="font-bold">Rata‑rata Nilai:</span>
                        <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full font-bold">{{ number_format($avgNilai, 1) }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="font-bold">Peringkat Kelas:</span>
                        <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full font-bold">{{ $rankNumber ?? '-' }}/{{ $classTotal ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Nilai --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-6">
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-chart-line text-green-500 text-xl"></i>
                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full font-medium">{{ $gradeDesc }}</span>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Rata‑rata Nilai</h3>
                <p class="text-2xl md:text-3xl font-bold text-green-500 mb-1">{{ number_format($avgNilai, 1) }}</p>
                <p class="text-xs md:text-sm text-gray-500">Skala 0–100</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-percentage text-blue-500 text-xl"></i>
                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-medium">
                        {{ $avgSemester >= 90 ? 'Sangat Baik' : ($avgSemester >= 80 ? 'Baik' : ($avgSemester >= 70 ? 'Cukup' : 'Perlu Perbaikan')) }}
                    </span>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Rata‑rata Semester</h3>
                <p class="text-2xl md:text-3xl font-bold text-blue-500 mb-1">{{ number_format($avgSemester, 1) }}</p>
                <p class="text-xs md:text-sm text-gray-500">Semester berjalan</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-chart-bar text-purple-500 text-xl"></i>
                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full font-medium">
                        {{ $improvement > 0 ? 'Naik' : ($improvement < 0 ? 'Turun' : 'Stabil') }}
                    </span>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Perkembangan</h3>
                <p class="text-2xl md:text-3xl font-bold text-purple-500 mb-1">{{ $improvement > 0 ? '+' : ''}}{{ number_format($improvement, 1) }}</p>
                <p class="text-xs md:text-sm text-gray-500">Dari periode sebelumnya</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-medal text-orange-500 text-xl"></i>
                    <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full font-medium">Juara</span>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Peringkat Kelas</h3>
                <p class="text-2xl md:text-3xl font-bold text-orange-500 mb-1">
                    @if($rankNumber)
                        #{{ $rankNumber }}
                    @else
                        -
                    @endif
                </p>
                <p class="text-xs md:text-sm text-gray-500">Dari {{ $classTotal ?? '-' }} siswa</p>
            </div>
        </div>

        {{-- Nilai per Mapel & Tren + Pencapaian --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            {{-- Nilai per Mapel --}}
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Nilai Semester Berjalan</h3>
                <div class="space-y-4">
                    @forelse($nilaiPerMapel as $item)
                        @php
                            // Pilih warna latar berdasarkan kategori
                            $gradientClasses = [
                                'Sangat Baik' => 'from-purple-50 to-blue-50',
                                'Baik'       => 'from-orange-50 to-yellow-50',
                                'Cukup'      => 'from-green-50 to-blue-50',
                                'Perlu Perbaikan' => 'from-gray-50 to-slate-50'
                            ];
                            $color = $gradientClasses[$item->kategori] ?? 'from-gray-50 to-slate-50';
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r {{ $color }} rounded-xl">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-book-open text-purple-500 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base">{{ $item->nama_mapel }}</h4>
                                    <p class="text-xs text-gray-500">Mapel: {{ $item->nama_mapel }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-purple-600">{{ $item->grade }}</p>
                                <p class="text-xs text-gray-500">{{ $item->nilai }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada nilai rapor.</p>
                    @endforelse
                </div>
            </div>

            {{-- Tren Nilai, Pencapaian, Peringkat --}}
            <div class="space-y-6">
                {{-- Tren Nilai --}}
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Tren Nilai</h3>
                    <div class="space-y-3">
                        @forelse($trenNilai as $tren)
                            @php
                                // Tentukan warna bar berdasarkan rata2
                                $warna = $tren->rata_rata >= 90 ? 'bg-purple-500' : ($tren->rata_rata >= 80 ? 'bg-green-400' : 'bg-blue-400');
                                // Lebar bar (persentase, max 100)
                                $width = min(100, max(0, $tren->rata_rata));
                            @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">{{ $tren->periode }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="{{ $warna }} h-2 rounded-full" style="width: {{ $width }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold {{ $tren->rata_rata >= 90 ? 'text-purple-500' : ($tren->rata_rata >= 80 ? 'text-green-500' : 'text-blue-500') }}">{{ number_format($tren->rata_rata, 1) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data tren nilai.</p>
                        @endforelse
                    </div>
                    @if($improvement > 0)
                        <div class="mt-4 p-3 bg-green-50 rounded-xl flex items-center space-x-2">
                            <i class="fas fa-arrow-up text-green-600"></i>
                            <p class="text-sm text-green-700 font-medium">Perkembangan konsisten! Pertahankan performamu.</p>
                        </div>
                    @elseif($improvement < 0)
                        <div class="mt-4 p-3 bg-red-50 rounded-xl flex items-center space-x-2">
                            <i class="fas fa-arrow-down text-red-600"></i>
                            <p class="text-sm text-red-700 font-medium">Perlu perbaikan di periode berikutnya.</p>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-gray-50 rounded-xl flex items-center space-x-2">
                            <i class="fas fa-minus text-gray-600"></i>
                            <p class="text-sm text-gray-700 font-medium">Nilai stabil.</p>
                        </div>
                    @endif
                </div>

                {{-- Pencapaian Akademik: badge dan sertifikat --}}
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Pencapaian Akademik</h3>
                    <div class="space-y-3">
                        @forelse($badges as $badge)
                            <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl">
                                <i class="fas fa-award text-yellow-600"></i>
                                <div>
                                    <h5 class="font-bold text-gray-800 text-sm">{{ $badge->nama_pencapaian }}</h5>
                                    <p class="text-xs text-gray-600">Kategori: {{ $badge->kategori }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada badge pencapaian.</p>
                        @endforelse

                    </div>
                </div>

                {{-- Peringkat Kelas --}}
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Peringkat Kelas — {{ $kelasName }}</h3>
                    <div class="space-y-3">
                        @forelse($topRanking as $i => $row)
                            @php
                                $isCurrent = $row->siswa_id == auth()->id();
                                $bg    = $isCurrent ? 'bg-gradient-to-r from-yellow-100 to-orange-100 border-2 border-yellow-300' : 'bg-gray-50';
                                $textC = $isCurrent ? 'text-orange-600' : 'text-gray-600';
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-xl {{ $bg }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-user{{ $isCurrent ? '-graduate' : '' }} {{ $textC }}"></i>
                                    <div>
                                        <h5 class="font-bold text-gray-800 text-sm">
                                            {{ $row->nama_lengkap ?? 'Siswa' }}
                                            @if($isCurrent)
                                                (Kamu)
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <span class="text-lg font-bold {{ $textC }}">#{{ $row->rank }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data peringkat.</p>
                        @endforelse
                        @if($rankNumber && $rankNumber > 1)
                        <div class="text-center pt-2">
                            <p class="text-xs text-gray-500">Kamu unggul {{ number_format(($topRanking[0]->total_semua_mapel ?? 0) - $totalSkorSiswa, 1) }} poin dari peringkat ke‑1.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-baseLMS>
