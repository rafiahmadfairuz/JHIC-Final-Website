<x-baseLMSDashboard>
    <div id="jurusan" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-building text-blue-600 mr-3"></i>
                    Manajemen Jurusan
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Jurusan
                </button>
            </div>

            <!-- Form Jurusan -->
            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Jurusan</h4>
                <form id="formJurusan" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="jurusan_id" name="id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Jurusan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_jurusan" id="nama_jurusan"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama jurusan">
                            </div>
                            @error('nama_jurusan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Jurusan</label>
                            <div class="drag-area rounded-lg p-6 text-center cursor-pointer"
                                onclick="document.getElementById('gambar_jurusan').click()">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Drag & drop atau klik untuk upload</p>
                                <input type="file" id="gambar_jurusan" name="gambar_jurusan" class="hidden"
                                    accept="image/*">
                            </div>
                            @error('gambar_jurusan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                <span id="btn-submit-text">Simpan Jurusan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Jurusan -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="table-body">
                        @foreach ($jurusans as $j)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $j->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $j->nama_jurusan }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if ($j->gambar_jurusan)
                                        <img src="{{ asset('img/' . $j->gambar_jurusan) }}"
                                            class="w-10 h-10 object-cover rounded-lg">
                                    @else
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-blue-600"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $j->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $j->id }}" data-nama="{{ $j->nama_jurusan }}"
                                        data-gambar="{{ $j->gambar_jurusan }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $j->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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


    <!-- Modal Notifikasi -->
    @if (session('success'))
        <div id="successModal"
            class="fixed bottom-5 right-5 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
            <i class="fas fa-check-circle text-2xl"></i>
            <div>{{ session('success') }}</div>
        </div>
        <script>
            setTimeout(() => document.getElementById('successModal')?.remove(), 4000);
        </script>
    @endif
    @if (session('error'))
        <div id="errorModal"
            class="fixed bottom-5 right-5 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
            <i class="fas fa-times-circle text-2xl"></i>
            <div>{{ session('error') }}</div>
        </div>
        <script>
            setTimeout(() => document.getElementById('errorModal')?.remove(), 4000);
        </script>
    @endif

    <script>
        document.getElementById('btn-tambah').addEventListener('click', () => {
            document.getElementById('form-container').classList.toggle('hidden');
            document.getElementById('formJurusan').reset();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formJurusan').action = "{{ route('jurusan.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Jurusan';
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('form-container').classList.remove('hidden');
                document.getElementById('nama_jurusan').value = btn.dataset.nama;
                document.getElementById('jurusan_id').value = btn.dataset.id;
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('formJurusan').action = '/lms/dashboard/jurusan/' + btn.dataset.id;
                document.getElementById('btn-submit-text').textContent = 'Update Jurusan';
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
            fetch(`/lms/dashboard/jurusan/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        });
    </script>
</x-baseLMSDashboard>
