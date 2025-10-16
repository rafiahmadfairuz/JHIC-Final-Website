<div>
    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold">Daftar Pesanan</h2>
                    </div>
                    <div class="mb-4 flex items-center gap-3">
                        <label for="status" class="font-medium text-gray-700 dark:text-gray-300">Filter Status</label>
                        <select name="status" id="status"
                            class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
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
                            <th class="p-3">Pembeli</th>
                            <th class="p-3">Produk</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $orders->firstItem() + $index }}</td>
                                <td class="p-3">{{ $order->pembeli->name }}</td>
                                <td>
                                    @foreach ($order->items as $item)
                                        {{ $item->produk->nama }} ({{ $item->qty }}),
                                    @endforeach
                                </td>
                                <td>Rp {{ $order->total }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td class="p-3 space-x-2">
                                    <button wire:click="edit({{ $order->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $order->id }})" onclick="openDeleteModal()"
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Create/Edit -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-bold mb-4">
                    Update Status
                </h3>
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="block mb-1">Status</label>
                        <select wire:model="status" class="w-full border rounded px-3 py-2">
                            <option value="">pilih Status</option>
                            <option value="pending">Pending</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
                        @error('status')
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
                <h3 class="text-lg font-bold mb-4">Hapus Pesanan</h3>
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
