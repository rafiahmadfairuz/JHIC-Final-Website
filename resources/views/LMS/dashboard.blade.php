<x-baseLMS>
    <div class="p-4 md:p-6">
        <div
            class="bg-gradient-to-r from-purple-main to-blue-main rounded-lg p-6 text-white mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-20">
                <div class="text-8xl">👋</div>
            </div>
            <div class="relative z-10">
                <h2 class="text-xl md:text-2xl font-bold mb-2">Halo, {{ $user->nama_lengkap }}!</h2>
                <p class="text-purple-100 mb-4">Selamat datang kembali di portal siswa Anda. Mari lanjutkan pembelajaran
                    Anda!</p>
                <a href="{{ route('lms.profile') }}"
                    class="inline-block bg-white bg-opacity-30 hover:bg-opacity-40 text-white text-sm font-medium px-4 py-2 rounded-full transition-colors">Lihat
                    Profil Anda</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-6">
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-2xl text-blue-600"><i class="fas fa-book-open text-3xl"></i></div>
                    <span
                        class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-medium">{{ $totalKursus }}
                        Aktif</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Kursus Saya</h3>
                <p class="text-3xl font-bold text-blue-main mb-1">{{ $totalKursus }}</p>
                <p class="text-sm text-gray-500">Total kursus terdaftar</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-2xl text-orange-600"><i class="fas fa-tasks text-3xl"></i></div>
                    <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full font-medium">Segera</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Tugas</h3>
                <p class="text-3xl font-bold text-orange-main mb-1">{{ $tugasBelumSelesai }}</p>
                <p class="text-sm text-gray-500">Tugas yang belum selesai</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-2xl text-purple-600"><i class="fas fa-envelope-open-text text-3xl"></i></div>
                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full font-medium">Baru</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Track Perilaku</h3>
                <p class="text-3xl font-bold text-purple-main mb-1">{{ $totalPerilaku }}</p>
                <p class="text-sm text-gray-500">Total Track Perilaku</p>
            </div>


            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-2xl text-green-600"><i class="fas fa-trophy text-3xl"></i></div>
                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full font-medium">Top
                        {{ $peringkatUser }}</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Peringkat Seangkatan</h3>
                <p class="text-2xl md:text-3xl font-bold text-green-main mb-1">#{{ $peringkatUser }}</p>
                <p class="text-xs md:text-sm text-gray-500">Dari {{ $totalSiswa }} siswa</p>

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tugas Mendatang</h3>
                <!-- kasih max height dan scroll di container tugas -->
                <div
                    class="space-y-4 max-h-80 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    @forelse($tugasMendatang as $t)
                        <div
                            class="flex items-center justify-between p-3 rounded-xl {{ $loop->index % 3 == 0 ? 'bg-pastel-orange' : ($loop->index % 3 == 1 ? 'bg-pastel-blue' : 'bg-pastel-purple') }}">
                            <div class="flex items-center space-x-3">
                                <div class="text-xl">
                                    <i
                                        class="fas fa-tasks text-{{ $loop->index % 3 == 0 ? 'orange' : ($loop->index % 3 == 1 ? 'blue' : 'purple') }}-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base">{{ $t->nama_tugas }}</h4>
                                    <p class="text-xs text-gray-500">{{ $t->kursus->mapel->nama_mapel ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-sm font-medium text-{{ $loop->index % 3 == 0 ? 'orange-main' : ($loop->index % 3 == 1 ? 'blue-main' : 'purple-main') }}">
                                    {{ optional($t->batas_pengumpulan)->diffForHumans() ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ rand(80, 120) }} Poin</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Tidak ada tugas mendatang.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Progres Kursus</h3>
                <!-- scroll juga kalau kebanyakan -->
                <div
                    class="space-y-4 max-h-80 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    @foreach ($progressKursus as $p)
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-purple-main font-bold text-sm flex-shrink-0"
                                style="background: conic-gradient(#8B5CF6 0deg {{ $p['progress'] * 3.6 }}deg, #E5E7EB {{ $p['progress'] * 3.6 }}deg 360deg);">
                                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center">
                                    {{ $p['progress'] }}%
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 text-base">{{ $p['nama'] }}</h4>
                                <p class="text-sm text-gray-500">{{ $p['selesai'] }} dari {{ $p['total'] }} tugas
                                    selesai</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-3">
                @foreach ($aktivitasTerbaru as $a)
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-{{ $a['warna'] }}-100 text-{{ $a['warna'] }}-main rounded-full flex items-center justify-center">
                            <i class="fas {{ $a['icon'] }} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800"><span class="font-bold">{{ $a['judul'] }}:</span>
                                {{ $a['deskripsi'] }}</p>
                            <p class="text-xs text-gray-500">{{ $a['waktu'] }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-baseLMS>
