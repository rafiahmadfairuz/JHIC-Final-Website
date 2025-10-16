<x-kwu.dashboard.app>
    <main class="p-6 space-y-8">

        
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mt-6">

            <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProduk }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Kategori</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKategori }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Order</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrder }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Toko</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalToko }}</p>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Produk Terbaru</h2>
            <ul class="divide-y divide-gray-200">
                @foreach($latestProduk as $produk)
                    <li class="py-2 flex justify-between">
                        <span>{{ $produk->nama }} ({{ $produk->kategori->nama }})</span>
                        <span class="font-semibold text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Order Terbaru</h2>
            <ul class="divide-y divide-gray-200">
                @foreach($latestOrder as $order)
                    <li class="py-2 flex justify-between">
                        <span>Pembeli ID: {{ $order->pembeli_id }}</span>
                        <span class="font-semibold text-gray-700">{{ ucfirst($order->status) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </main>
</x-kwu.dashboard.app>
