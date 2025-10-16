<x-kwu.landing.app>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-2xl p-6 flex items-center space-x-6 mb-8">
            <img src="https://via.placeholder.com/100" alt="Foto Profil" class="w-24 h-24 rounded-full border shadow">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ Auth::user()->nama_lengkap }}</h1>
                <p class="text-gray-500">Email: {{ Auth::user()->email }}</p>
                <a href="{{ route('dashboard.penjual.produk') }}" class="text-gray-500">Kunjungi Dashboard Toko</a>
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
                                <th class="p-3">Nama</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <ul class="list-disc list-inside">
                                            @foreach ($order->items as $item)
                                                <li>
                                                    {{ $item->produk->nama }}
                                                    (Qty: {{ $item->qty }},
                                                    Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <span
                                            class="
                            @if ($order->status == 'pending') text-yellow-600 font-semibold
                            @elseif($order->status == 'selesai') text-green-600 font-semibold
                            @else text-red-600 font-semibold @endif
                        ">
                                            {{ ucfirst($order->status) }}
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
