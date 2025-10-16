<x-kwu.dashboard.app>
    <div>
        <main class="p-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold">Daftar Toko</h2>
                </div>
                <div class="overflow-x-auto">
                    @if (session()->has('message'))
                        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="p-3">No</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tokos as $index => $toko)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $tokos->firstItem() + $index }}</td>
                                    <td class="p-3">{{ $toko->nama_toko }}</td>
                                    <td class="p-3">{{ $toko->deskripsi }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $tokos->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-kwu.dashboard.app>
