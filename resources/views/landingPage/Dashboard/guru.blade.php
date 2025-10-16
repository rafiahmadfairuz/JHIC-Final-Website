<x-baseDashboard>
    <div id="guru" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-user-tie text-blue-600 mr-3"></i> Manajemen Data Guru
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Guru
                </button>
            </div>

            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Guru</h4>
                <form id="formGuru" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="guru_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Guru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tie text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_guru" id="nama_guru"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama guru">
                            </div>
                            @error('nama_guru')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Guru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-gray-400"></i>
                                </div>
                                <input type="text" name="jabatan_guru" id="jabatan_guru"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Contoh: Guru RPL / Kepala Program">
                            </div>
                            @error('jabatan_guru')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Guru</label>
                            <div class="drag-area rounded-lg p-6 text-center cursor-pointer border border-gray-300"
                                onclick="document.getElementById('guru_img').click()">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Drag & drop atau klik untuk upload foto guru</p>
                                <input type="file" id="guru_img" name="guru_img" class="hidden" accept="image/*">
                                <div id="previewContainer" class="mt-3 hidden">
                                    <img id="previewImg" src=""
                                        class="rounded-lg w-32 h-32 object-cover mx-auto">
                                </div>
                            </div>
                            @error('guru_img')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i> <span id="btn-submit-text">Simpan Guru</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($gurus as $g)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $g->id }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($g->guru_img)
                                        <img src="{{ asset('img/guru/' . $g->guru_img) }}"
                                            class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $g->nama_guru }}</td>
                                <td class="px-6 py-4 text-sm">{{ $g->jabatan_guru }}</td>
                                <td class="px-6 py-4 text-sm">{{ $g->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $g->id }}" data-nama="{{ $g->nama_guru }}"
                                        data-jabatan="{{ $g->jabatan_guru }}" data-gambar="{{ $g->guru_img }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $g->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $gurus->links('pagination::tailwind') }}</div>
        </div>
    </div>

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
        const preview = document.getElementById('previewContainer');
        const img = document.getElementById('previewImg');

        document.getElementById('guru_img').addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = ev => {
                    img.src = ev.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('btn-tambah').onclick = () => {
            const f = document.getElementById('form-container');
            f.classList.toggle('hidden');
            document.getElementById('formGuru').reset();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formGuru').action = "{{ route('guru.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Guru';
            preview.classList.add('hidden');
        };

        document.querySelectorAll('.btn-edit').forEach(btn => btn.onclick = () => {
            document.getElementById('form-container').classList.remove('hidden');
            document.getElementById('formGuru').reset();
            document.getElementById('guru_id').value = btn.dataset.id;
            document.getElementById('nama_guru').value = btn.dataset.nama;
            document.getElementById('jabatan_guru').value = btn.dataset.jabatan;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('formGuru').action = '/dashboardLanding/guru/' + btn.dataset.id;
            document.getElementById('btn-submit-text').textContent = 'Update Guru';
            if (btn.dataset.gambar) {
                img.src = '/img/guru/' + btn.dataset.gambar;
                preview.classList.remove('hidden');
            }
        });

        let delId = null;
        document.querySelectorAll('.btn-delete').forEach(btn => btn.onclick = () => {
            delId = btn.dataset.id;
            document.getElementById('deleteModal').classList.remove('hidden');
        });
        document.getElementById('cancelDelete').onclick = () => document.getElementById('deleteModal').classList.add(
            'hidden');
        document.getElementById('confirmDelete').onclick = () => {
            fetch('/dashboardLanding/guru/' + delId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        };
    </script>
</x-baseDashboard>
