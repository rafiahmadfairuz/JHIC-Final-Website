<div>
    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Daftar Produk</h2>

                <div class="flex items-center space-x-2">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Cari produk..."
                        class="px-3 py-2 border rounded text-sm focus:ring focus:ring-blue-300" />

                    <button wire:click="create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Add
                    </button>
                </div>
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
                            <th class="p-3">Harga</th>
                            <th class="p-3">Stok</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $index => $produk)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $produks->firstItem() + $index }}</td>
                                <td class="p-3">{{ $produk->nama }}</td>
                                <td class="p-3">{{ $produk->harga }}</td>
                                <td class="p-3">{{ $produk->stok }}</td>
                                <td class="p-3">{{ $produk->kategori->nama }}</td>
                                <td class="p-3 space-x-2">
                                    <button wire:click="edit({{ $produk->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $produk->id }})" onclick="openDeleteModal()"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </main>

    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-bold mb-4">
                    {{ $produk_id ? 'Edit Produk' : 'Tambah Produk' }}
                </h3>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <input type="number" wire:model="toko_id" value="1" hidden>
                    <div class="mb-3">
                        <label class="block mb-1">Nama</label>
                        <input type="text" wire:model="nama" class="w-full border rounded px-3 py-2">
                        @error('nama')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Harga</label>
                        <input type="number" wire:model="harga" class="w-full border rounded px-3 py-2">
                        @error('harga')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Stok</label>
                        <input type="number" wire:model="stok" class="w-full border rounded px-3 py-2">
                        @error('stok')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Kategori</label>
                        <select wire:model="kategori_id" class="w-full border rounded px-3 py-2">
                            <option value="">pilih kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Gambar</label>
                        <input type="file" wire:model="gambar" class="w-full border rounded px-3 py-2">
                        @error('gambar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Deskripsi</label>
                        <textarea wire:model="deskripsi" class="w-full border rounded px-3 py-2"></textarea>
                        @error('deskripsi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" wire:click="$set('isOpen', false)"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    @if ($deleteId)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h3 class="text-lg font-bold mb-4">Hapus Produk</h3>
                <p>Apakah yakin ingin menghapus data ini?</p>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" wire:click="$set('deleteId', null)"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="button" wire:click="delete"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>
    @endif

</div>
