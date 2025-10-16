<x-kwu.landing.app>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="rounded-2xl overflow-hidden shadow-md">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Produk" class="w-full h-auto">
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-2">{{ $produk->nama }}</h2>
                <p class="text-blue-600 text-xl font-semibold mb-4">Rp {{ $produk->harga }}</p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ $produk->deskripsi }}
                </p>
                <div class="flex items-center space-x-3 mb-4">
                    <form action="{{ route('checkout', $produk->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="qty" id="qtyInput" value="1">
                        <button type="submit"
                            class="bg-indigo-500 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-600">
                            Checkout
                        </button>
                    </form>
                </div>
                <div class="flex items-center mb-4">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $produk->toko->nama_toko }}</p>
                        <a href="{{ route('landing.kwu.detailtoko', $produk->toko->id) }}"
                            class="text-sm text-indigo-500 hover:underline">Kunjungi Toko</a>
                    </div>
                </div>
                <div class="flex space-x-3 border-b mb-4">
                    <button class="tab-btn px-4 py-2 border-b-2 text-indigo-500 font-medium"
                        data-tab="details">Detail</button>
                </div>
                <div id="tabContent">
                    <div id="details" class="tab-content">
                        <p class="text-gray-700">Detail produk: {{ $produk->nama }}</p>
                        <p class="text-gray-700">Stok: {{ $produk->stok }}</p>
                        <p class="text-gray-700">Kategori: {{ $produk->kategori->nama }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-kwu.landing.app>
