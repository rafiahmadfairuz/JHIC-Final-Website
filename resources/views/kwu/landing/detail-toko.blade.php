<x-kwu.landing.app>
    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-md p-6 flex items-center space-x-6 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $toko->nama_toko }}</h1>
                <p class="text-gray-600 mt-2 max-w-lg">{{ $toko->deskripsi }}</p>
                <div class="flex items-center mt-4 space-x-3">
                    <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        {{ $toko->produks->count() }} Produk
                    </span>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Produk Toko</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($toko->produks as $produk)
                    <a href="{{ route('landing.kwu.detailproduk', $produk->id) }}"
                        class="group block bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden relative">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $produk->kategori->nama ?? 'Uncategorized' }}</p>
                            <h3 class="font-semibold text-gray-800 truncate">{{ $produk->nama }}</h3>
                            <p class="text-xs text-gray-500">Dijual oleh {{ $toko->nama_toko }}</p>

                            <div class="flex items-center justify-between mt-3">
                                <span class="text-blur-600 font-bold text-lg">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded-lg shadow">
                                    <i class="bi bi-bag"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-kwu.landing.app>
