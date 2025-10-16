<x-baseLMS>
    <div id="homepage" class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Platform Kursus Kelas {{ Auth::user()->profile->kelas->tingkat }} </h1>
            <p class="text-gray-600">Pilih kursus yang ingin Anda pelajari</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
            @forelse($kursuses as $kursus)
                <div class="bg-white rounded-xl shadow-lg card-hover fade-in cursor-pointer">
                    <div class="relative">
                        <div
                            class="h-48 bg-gradient-to-br {{ $kursus['gradient'] }} rounded-t-xl flex items-center justify-center">
                            <i class="fas {{ $kursus['icon'] }} text-white text-6xl"></i>
                        </div>
                        <div class="absolute top-3 left-3">
                            <span
                                class="bg-white bg-opacity-90 text-{{ $kursus['color'] }}-700 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $kursus['mapel'] }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                {{ $kursus['progress'] }}% Selesai
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $kursus['nama'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $kursus['deskripsi'] }}</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span>{{ $kursus['progress'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-{{ $kursus['color'] }}-500 h-2 rounded-full"
                                    style="width: {{ $kursus['progress'] }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('lms.kursus.show', $kursus['id']) }}"
                            class="w-full block text-center bg-{{ $kursus['color'] }}-500 hover:bg-{{ $kursus['color'] }}-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lanjutkan Kursus
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Belum ada kursus untuk kelas Anda.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $kursuses->links('pagination::tailwind') }}
        </div>
    </div>
</x-baseLMS>
