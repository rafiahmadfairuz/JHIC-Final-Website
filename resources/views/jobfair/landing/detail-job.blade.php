<x-jobfair.landing.app>
    <section class="bg-[#f4f6fb] py-10 px-6">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="text-4xl">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $pekerjaan->judul }}</h1>
                        <p class="text-gray-600">
                            <a href="{{ route('jobfair.detail', $pekerjaan->id) }}"
                                class="hover:underline text-blue-600 font-medium">
                                {{ $pekerjaan->perusahaan->nama }}
                            </a>
                            - {{ $pekerjaan->lokasi }}
                        </p>
                        <div class="flex space-x-3 mt-2">
                            <span class="text-sm text-gray-600"><i class="bi bi-clock"></i>
                                {{ $pekerjaan->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Syarat</h2>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>{{ $pekerjaan->syarat }}</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Pekerjaan</h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $pekerjaan->deskripsi }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow space-y-6 h-fit">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Tentang Perusahaan</h2>
                    <p class="text-gray-700"><strong>{{ $pekerjaan->perusahaan->nama }}</strong></p>
                    <p class="text-sm text-gray-600">{{ $pekerjaan->perusahaan->alamat }}</p>
                    @if ($pekerjaan->perusahaan->website)
                        <a href="{{ $pekerjaan->perusahaan->website }}" target="_blank"
                            class="text-blue-500 text-sm hover:underline">
                            {{ $pekerjaan->perusahaan->website }}
                        </a>
                    @endif
                </div>
                <div class="pt-4 border-t">
                    <a href="{{ route('jobfair.melamar', $pekerjaan->id) }}"
                        class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 rounded-lg transition">
                        Lamar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-jobfair.landing.app>
