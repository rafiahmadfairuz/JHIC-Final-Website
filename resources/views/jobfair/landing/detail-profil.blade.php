<x-kwu.landing.app>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-2xl p-6 flex items-center space-x-6 mb-8">
            <img src="https://via.placeholder.com/100" alt="Foto Profil" class="w-24 h-24 rounded-full border shadow">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Budi Santoso</h1>
                <p class="text-gray-500">Email: budi@example.com</p>
                <p class="text-gray-500">Bergabung sejak: Jan 2023</p>
                <span
                    class="inline-block mt-2 px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-medium">Pembeli</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
            <div class="bg-white shadow rounded-2xl p-6 md:col-span-2">
                <h2 class="text-xl font-semibold mb-4">Riwayat Pesanan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Pekerjaan</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lamarans as $lamaran)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">
                                        {{ $lamaran->pekerjaan->judul }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ $lamaran->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <span
                                            class="
                            @if ($lamaran->status == 'pending') text-yellow-600 font-semibold
                            @elseif($lamaran->status == 'diterima') text-green-600 font-semibold
                            @else text-red-600 font-semibold @endif">
                                            {{ ucfirst($lamaran->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-kwu.landing.app>
