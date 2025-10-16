<x-baseLMSDashboard>
    <div id="mapel" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-book text-blue-600 mr-3"></i>
                    Manajemen Mata Pelajaran
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Mapel
                </button>
            </div>

            <!-- Form Mapel -->
            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Mata Pelajaran</h4>
                <form id="formMapel" method="POST">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="mapel_id" name="id">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Mata Pelajaran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_mapel" id="nama_mapel"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama mata pelajaran">
                            </div>
                            @error('nama_mapel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                <span id="btn-submit-text">Simpan Mata Pelajaran</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Mapel -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="table-body">
                        @foreach ($mapels as $m)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $m->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $m->nama_mapel }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $m->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $m->id }}" data-nama="{{ $m->nama_mapel }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $m->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $mapels->links('pagination::tailwind') }}</div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-60 z-50">
        <div class="absolute top-1/2 left-1/2 w-[90%] max-w-sm bg-white rounded-xl p-6 shadow-lg text-center"
            style="transform: translate(-50%, -50%);">
            <h2 class="text-lg font-semibold mb-4">Yakin ingin menghapus data ini?</h2>
            <div class="mt-4">
                <button id="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded-lg mx-2">Hapus</button>
                <button id="cancelDelete" class="bg-gray-300 px-4 py-2 rounded-lg mx-2">Batal</button>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="successModal"
            class="fixed bottom-5 right-5 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
            <i class="fas fa-check-circle text-2xl"></i>
            <div>{{ session('success') }}</div>
        </div>
        <script>
            setTimeout(() => document.getElementById('successModal')?.remove(), 4000)
        </script>
    @endif
    @if (session('error'))
        <div id="errorModal"
            class="fixed bottom-5 right-5 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
            <i class="fas fa-times-circle text-2xl"></i>
            <div>{{ session('error') }}</div>
        </div>
        <script>
            setTimeout(() => document.getElementById('errorModal')?.remove(), 4000)
        </script>
    @endif

    <script>
        document.getElementById('btn-tambah').addEventListener('click', () => {
            document.getElementById('form-container').classList.toggle('hidden');
            document.getElementById('formMapel').reset();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formMapel').action = "{{ route('mapel.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Mata Pelajaran';
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('form-container').classList.remove('hidden');
                document.getElementById('nama_mapel').value = btn.dataset.nama;
                document.getElementById('mapel_id').value = btn.dataset.id;
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('formMapel').action = '/lms/dashboard/mapel/' + btn.dataset.id;
                document.getElementById('btn-submit-text').textContent = 'Update Mata Pelajaran';
            });
        });

        let deleteId = null;
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', () => {
                deleteId = btn.dataset.id;
                document.getElementById('deleteModal').classList.remove('hidden');
            });
        });

        document.getElementById('cancelDelete').addEventListener('click', () => {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('confirmDelete').addEventListener('click', () => {
            fetch(`/lms/dashboard/mapel/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        });
    </script>
</x-baseLMSDashboard>
