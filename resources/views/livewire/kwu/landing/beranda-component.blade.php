<div class="bg-gradient-to-b from-blue-50 to-[#f4f6fb]">
    <section class="container mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 space-y-6">
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-gray-900">
                Temukan Produk <br />
                Yang Sesuai Dengan <br />
                <span class="text-blue-600">Keinginanmu</span>
            </h1>
            <p class="text-gray-600 text-lg">
                Carilah Produk sesuai minat kamu.
            </p>
            <a href="#products"
                class="inline-block mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow-md transition">
                Jelajahi Produk
            </a>
        </div>
        <div class="md:w-1/2 hidden md:flex mt-10 md:mt-0 justify-center">
            <img src="{{ asset('images/kwu.png') }}" alt="Ilustrasi Pekerjaan"
                class="w-72 md:w-96 drop-shadow-lg animate-bounce-slow" />
        </div>
    </section>
    <div class="container mx-auto flex justify-between items-center mb-6 relative" x-data
        @click.away="$wire.set('showFilter', false)">
        <h2 class="text-2xl font-bold">Produk</h2>
        <button wire:click="toggleFilter" class="p-2 border rounded-lg hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6 9h12M9 13.5h6M11 18h2" />
            </svg>
        </button>

        @if ($showFilter)
            <div class="absolute right-0 mt-10 w-72 bg-white border rounded-xl shadow-lg p-4 z-50">
                <h3 class="text-sm font-semibold mb-3">Filter Produk</h3>
                <div class="mb-3">
                    <label class="text-xs text-gray-600">Harga</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="number" wire:model.defer="temp_min_price" placeholder="Min"
                            class="border rounded-lg px-3 py-2 text-sm w-full focus:ring-1 focus:ring-blue-400">
                        <input type="number" wire:model.defer="temp_max_price" placeholder="Max"
                            class="border rounded-lg px-3 py-2 text-sm w-full focus:ring-1 focus:ring-blue-400">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-xs text-gray-600">Sort by</label>
                    <select wire:model.defer="temp_sort"
                        class="mt-1 border rounded-lg px-3 py-2 text-sm w-full focus:ring-1 focus:ring-blue-400">
                        <option value="default">Default Sorting</option>
                        <option value="priceLow">Price: Low to High</option>
                        <option value="priceHigh">Price: High to Low</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-xs text-gray-600">Kategori</label>
                    <select wire:model.defer="temp_selectedKategori"
                        class="mt-1 border rounded-lg px-3 py-2 text-sm w-full focus:ring-1 focus:ring-blue-400">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="applyFilter"
                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition shadow-md">
                    Terapkan
                </button>
            </div>
        @endif
    </div>
    <section class="bg-[#f4f6fb] bg-[url('{{ asset('images/Vector.png') }}')] bg-no-repeat bg-cover">
        <div id="products"
            class="container mx-auto px-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 pb-10 relative">
            @forelse ($produks as $produk)
                <a href="{{ route('landing.kwu.detailproduk', $produk->id) }}">
                    <div
                        class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden relative transition cursor-pointer">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Produk"
                            class="w-full h-56 object-cover" />
                        <div class="p-3">
                            <p class="text-xs text-gray-500">{{ $produk->kategori->nama }}</p>
                            <h3 class="font-semibold text-sm truncate">{{ $produk->nama }}</h3>
                            <p class="text-xs text-gray-500">Tara Store</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-blue-600 font-bold text-lg">{{ $produk->harga }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-2 sm:col-span-3 lg:col-span-4 text-center py-10 text-gray-500">
                    Produk tidak ditemukan
                </div>
            @endforelse
        </div>
    </section>
    <div class="my-6">
        {{ $produks->links('vendor.pagination.custom') }}
    </div>
</div>
