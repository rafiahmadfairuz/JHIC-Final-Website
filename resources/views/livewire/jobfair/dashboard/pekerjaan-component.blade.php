<div>
    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Daftar Pekerjaan</h2>

                <div class="flex items-center space-x-2">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Cari pekerjaan..."
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
                            <th class="p-3">Perusahaan</th>
                            <th class="p-3">Lokasi</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pekerjaans as $index => $pekerjaan)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $pekerjaans->firstItem() + $index }}</td>
                                <td class="p-3">{{ $pekerjaan->judul }}</td>
                                <td class="p-3">{{ $pekerjaan->perusahaan->nama }}</td>
                                <td class="p-3">{{ $pekerjaan->lokasi }}</td>
                                <td class="p-3">{{ $pekerjaan->status }}</td>
                                <td class="p-3 space-x-2">
                                    <button wire:click="edit({{ $pekerjaan->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $pekerjaan->id }})" onclick="openDeleteModal()"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center mt-5">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $pekerjaans->links() }}
                </div>
            </div>
        </div>
    </main>
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-bold mb-4">
                    {{ $pekerjaan_id ? 'Edit Pekerjaan' : 'Tambah Pekerjaan' }}
                </h3>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="block mb-1">Judul</label>
                        <input type="text" wire:model="judul" class="w-full border rounded px-3 py-2">
                        @error('judul')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Perusahaan</label>
                        <select wire:model="perusahaan_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- pilih perusahaan --</option>
                            @foreach ($perusahaans as $prs)
                                <option value="{{ $prs->id }}">{{ $prs->nama }}</option>
                            @endforeach
                        </select>
                        @error('perusahaan_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Lokasi</label>
                        <input type="text" wire:model="lokasi" class="w-full border rounded px-3 py-2">
                        @error('lokasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Batas</label>
                        <input type="date" wire:model="batas" class="w-full border rounded px-3 py-2">
                        @error('batas')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Status</label>
                        <select wire:model="status" class="w-full border rounded px-3 py-2">
                            <option value="">-- pilih status --</option>
                            <option value="aktif">Aktif</option>
                            <option value="tutup">Tutup</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Poster</label>
                        <input type="file" wire:model="poster" class="w-full border rounded px-3 py-2">
                        @error('poster')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Syarat</label>
                        <textarea wire:model="syarat" class="w-full border rounded px-3 py-2"></textarea>
                        @error('syarat')
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
                <h3 class="text-lg font-bold mb-4">Hapus Pekerjaan</h3>
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
