<div>
    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Daftar Perusahaan</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Cari perusahaan..."
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
                            <th class="p-3">Alamat</th>
                            <th class="p-3">Jenis Perusahaan</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perusahaans as $index => $perusahaan)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $perusahaans->firstItem() + $index }}</td>
                                <td class="p-3">{{ $perusahaan->nama }}</td>
                                <td class="p-3">{{ $perusahaan->alamat }}</td>
                                <td class="p-3">{{ $perusahaan->jenis_perusahaan }}</td>
                                <td class="p-3 space-x-2">
                                    <button wire:click="edit({{ $perusahaan->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $perusahaan->id }})"
                                        onclick="openDeleteModal()"
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
                    {{ $perusahaans->links() }}
                </div>
            </div>
        </div>
    </main>

    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h3 class="text-lg font-bold mb-4">
                    {{ $perusahaan_id ? 'Edit Perusahaan' : 'Tambah Perusahaan' }}
                </h3>
                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label class="block mb-1">Nama</label>
                        <input type="text" wire:model="nama" class="w-full border rounded px-3 py-2">
                        @error('nama')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Alamat</label>
                        <input type="text" wire:model="alamat" class="w-full border rounded px-3 py-2">
                        @error('alamat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Jenis Perusahaan</label>
                        <select wire:model="jenis_perusahaan" class="w-full border rounded px-3 py-2">
                            <option value="">-- pilih --</option>
                            <option value="pt">PT</option>
                            <option value="cv">CV</option>
                            <option value="ud">UD</option>
                        </select>
                        @error('jenis_perusahaan')
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
                <h3 class="text-lg font-bold mb-4">Hapus Perusahaan</h3>
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
