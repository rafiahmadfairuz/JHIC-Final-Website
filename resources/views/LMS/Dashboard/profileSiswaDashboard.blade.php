<x-baseLMSDashboard>
    <div class="max-w-7xl mx-auto px-6 py-10">

        <!-- HEADER -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Cari Profile Siswa</h1>

        <!-- SEARCH & FILTER FORM -->
        <form method="GET" action="{{ route('lms.dashboard.profile.cari') }}"
            class="flex flex-col md:flex-row gap-3 md:gap-4 mb-8">
            <!-- Search Box -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="fas fa-search text-purple-400"></i>
                </div>
                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari berdasarkan nama"
                    class="w-full pl-12 pr-5 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Dropdown Kelas -->
            <select name="kelas_id"
                class="px-5 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Semua Kelas</option>
                @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->tingkat }} {{ $kelas->jurusan->nama_jurusan }} {{ $kelas->urutan_kelas }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-full font-medium shadow">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>

        <!-- RESULT COUNT -->
        <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
            <div>
                Ditemukan <span class="text-purple-600 font-semibold">{{ $profiles->count() }}</span> Profile
            </div>
        </div>

        <!-- LIST PROFILE -->
        <div class="space-y-6">
            @forelse($profiles as $p)
                <a href="{{ route('lms.dashboard.profile.cari.detail', $p->user->id) }}"
                    class="block bg-white rounded-xl shadow-md p-6 job-card cursor-pointer hover:bg-gray-50 transition">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <!-- Foto -->
                        <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center overflow-hidden">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}" class="w-full h-full object-cover">
                            @else
                                <span class="font-semibold text-blue-600 text-lg">
                                    {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                </span>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $p->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $p->user->email }}</p>

                            <div class="flex flex-wrap gap-2">
                                @php
                                    $badges = \App\Models\BadgePencapaianSiswa::with('badgePencapaian')
                                        ->where('siswa_id', $p->user_id)
                                        ->take(3)
                                        ->get();
                                @endphp
                                @foreach ($badges as $b)
                                    <span
                                        class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $b->badgePencapaian->nama_pencapaian }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Peringkat -->
                        <div class="text-right">
                            <p class="text-gray-800 font-semibold">Peringkat {{ $p->peringkat ?? '-' }} /
                                {{ $p->jumlah_siswa ?? '-' }}</p>
                            <p class="text-xs text-gray-500">Total Nilai: {{ $p->total_nilai ?? 0 }}</p>
                        </div>
                    </div>
                </a>

            @empty
                <p class="text-gray-500">Tidak ada hasil ditemukan.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $profiles->links() }}
        </div>
    </div>
</x-baseLMSDashboard>
