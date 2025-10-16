<x-kwu.dashboard.app>
    <div>
        <main class="p-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold">Daftar Order</h2>
                    </div>
                    <form method="GET" action="{{ route('dashboard.kwu.order') }}" class="mb-4 flex items-center gap-3">
                        <label for="status" class="font-medium text-gray-700 dark:text-gray-300">Filter Status</label>
                        <select name="status" id="status" onchange="this.form.submit()"
                            class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </form>
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
                                <th class="p-3">Pembeli</th>
                                <th class="p-3">Produk</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $orders->firstItem() + $index }}</td>
                                    <td class="p-3">{{ $order->pembeli->nama_lengkap }}</td>
                                    <td>
                                        @foreach ($order->items as $item)
                                            {{ $item->produk->nama }} ({{ $item->qty }}),
                                        @endforeach
                                    </td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-kwu.dashboard.app>
