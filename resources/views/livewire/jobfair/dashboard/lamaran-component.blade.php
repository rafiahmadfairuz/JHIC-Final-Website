<div>
    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Daftar Lamaran</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Cari lamaran..."
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
                            <th class="p-3">Pekerjaan</th>
                            <th class="p-3">Pelamar</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Show</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lamarans as $index => $lamaran)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $lamarans->firstItem() + $index }}</td>
                                <td class="p-3">{{ $lamaran->pekerjaan->judul }}</td>
                                <td class="p-3">{{ $lamaran->pelamar->nama_lengkap }}</td>
                                <td class="p-3">{{ $lamaran->status }}</td>
                                <td class="p-3">
                                    <a href="{{ route('landing.jobfair.lamaranprofil', ['pekerjaan' => $lamaran->id, 'id' => $lamaran->pelamar->id]) }}"
                                        class="text-blue-600 underline">
                                        Detail
                                    </a>
                                </td>
                                <td class="p-3 space-x-2">
                                    <button wire:click="edit({{ $lamaran->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $lamaran->id }})" onclick="openDeleteModal()"
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
                    {{ $lamarans->links() }}
                </div>
            </div>
        </div>
    </main>
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-bold mb-4">
                    Edit Lamaran
                </h3>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="block mb-1">Status</label>
                        <select wire:model="status" class="w-full border rounded px-3 py-2">
                            <option value="">-- pilih status --</option>
                            <option value="pending">Pending</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
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
                <h3 class="text-lg font-bold mb-4">Hapus Lamaran</h3>
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
