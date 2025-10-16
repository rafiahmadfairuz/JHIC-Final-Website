<div>

    <div class="bg-gradient-to-b from-blue-50 to-[#f4f6fb]">
        <!-- Hero Section -->
        <section class="container mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between">
            <!-- Left Content -->
            <div class="md:w-1/2 space-y-6">
                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-gray-900">
                    Temukan Pekerjaan <br />
                    Yang Sesuai Dengan <br />
                    <span class="text-blue-600">Keterampilanmu</span>
                </h1>
                <p class="text-gray-600 text-lg">
                    Carilah pekerjaan sesuai minat dan bakatmu.
                    Setelah lulus, jangan tunggu lama lagi — langsung kerja!
                </p>
                <p class="text-sm text-gray-500 mt-2 bg-white/60 px-4 py-2 rounded-lg inline-block">
                    <span class="font-bold text-red-500">NB :</span> Lengkapi berkas sebelum melamar ✨
                </p>
                <a href="#jobs"
                    class="inline-block mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow-md transition">
                    Jelajahi Lowongan
                </a>
            </div>
            <div class="md:w-1/2 hidden md:flex mt-10 md:mt-0 justify-center">
                <img src="{{ asset('images/pekerjaan.png') }}" alt="Ilustrasi Pekerjaan"
                    class="w-72 md:w-96 drop-shadow-lg animate-bounce-slow" />
            </div>
        </section>
    </div>
    <section id="jobs"
        class="bg-[#f4f6fb] bg-[url('{{ asset('images/Vector.png') }}')] bg-no-repeat bg-cover py-16 px-6">
        <div class="container mx-auto">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-gray-900">Lowongan Tersedia</h2>
            </div>
            <div class="space-y-2">
                @forelse($pekerjaans as $index => $pekerjaan)
                    <div
                        class="flex flex-col md:flex-row items-center justify-between bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg hover:border-blue-100 transition">
                        <div class="flex items-center space-x-4 w-full md:w-auto">
                            <div class="text-4xl text-blue-500">
                            </div>
                            <div>
                                <div class="flex items-center flex-wrap gap-2">
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $pekerjaan->judul }}</h3>
                                    <span class="text-sm text-gray-500"> {{ $pekerjaan->perusahaan->nama }}</span>
                                </div>
                                <div class="flex flex-wrap text-sm text-gray-600 gap-4 mt-2">
                                    <span class="flex items-center gap-1"><i class="bi bi-geo-alt"></i>
                                        {{ $pekerjaan->lokasi }}</span>
                                    <span class="flex items-center gap-1"><i class="bi bi-clock"></i>
                                        {{ $pekerjaan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <a href="{{ route('jobfair.detail', $pekerjaan->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm flex items-center space-x-2 font-medium transition shadow-md">
                                <span>Apply Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center">Belum ada pekerjaan tersedia.</p>
                @endforelse
            </div>
            <div class="mt-6 flex justify-center">
                {{ $pekerjaans->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>

</div>
