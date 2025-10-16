<x-baseLMS>
    <div id="course-tugas" class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Kursus -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('lms.kursus') }}" class="flex items-center text-red-600 hover:text-red-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kursus
                </a>
                <div class="text-sm text-gray-500">{{ $kursus->mapel->nama_mapel ?? '-' }}</div>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $kursus->nama_kursus }}</h1>
            <div class="text-gray-600 prose max-w-none mb-4">
                {!! nl2br(e($kursus->isi_kursus)) !!}
            </div>
        </div>

        <!-- Daftar Tugas -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Tugas {{ $kursus->mapel->nama_mapel ?? '' }}</h1>
                <p class="text-gray-600">Lengkapi tugas di bawah untuk mendapatkan nilai dan badge pencapaian</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                @forelse($tugasList as $tugas)
                    @php
                        $colors = [
                            ['from-red-400 to-red-600', 'red'],
                            ['from-blue-400 to-blue-600', 'blue'],
                            ['from-purple-400 to-purple-600', 'purple'],
                            ['from-green-400 to-green-600', 'green'],
                            ['from-yellow-400 to-yellow-600', 'yellow'],
                        ];
                        $color = $colors[$loop->index % count($colors)];
                        $gradient = $color[0];
                        $base = $color[1];
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg card-hover fade-in cursor-pointer">
                        <div class="relative">
                            <div
                                class="h-48 bg-gradient-to-br {{ $gradient }} rounded-t-xl flex items-center justify-center">
                                <i class="fas fa-tasks text-5xl text-white"></i>
                            </div>
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white bg-opacity-90 text-{{ $base }}-700 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $kursus->mapel->nama_mapel ?? '-' }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                @if ($tugas['selesai'])
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        Selesai
                                    </span>
                                @else
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        Belum Selesai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $tugas['nama'] }}</h3>
                            <p class="text-gray-600 text-sm mb-4">Deadline: {{ $tugas['deadline'] }}</p>

                            @if ($tugas['selesai'])
                                <a href="{{ route('lms.tugas.show', $tugas['id']) }}"
                                    class="w-full block text-center bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Selesai Dikerjakan
                                </a>
                            @else
                                <a href="{{ route('lms.tugas.show', $tugas['id']) }}"
                                    class="w-full block text-center bg-{{ $base }}-500 hover:bg-{{ $base }}-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Kerjakan Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada tugas untuk kursus ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-baseLMS>
