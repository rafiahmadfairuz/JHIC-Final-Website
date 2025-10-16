<x-baseLMSDashboard>
    <div id="kursus" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chalkboard-teacher text-blue-600 mr-3"></i>
                    Manajemen Kursus
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kursus
                </button>
            </div>

            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Kursus</h4>
                <form id="formKursus" method="POST">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="kursus_id" name="id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kursus</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chalkboard-teacher text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_kursus" id="nama_kursus"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama kursus">
                            </div>
                            @error('nama_kursus')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <select name="mapel_id" id="mapel_id"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($mapels as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mapel_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Guru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tie text-gray-400"></i>
                                </div>
                                <select name="guru_id" id="guru_id"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Guru</option>
                                    @foreach ($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('guru_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-door-open text-gray-400"></i>
                                </div>
                                <select name="kelas_id" id="kelas_id"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->urutan_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Isi Kursus</label>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <div class="editor-toolbar flex items-center space-x-2 p-2 bg-gray-50 border-b">
                                <button type="button" class="p-2 hover:bg-gray-200 rounded"
                                    onclick="document.execCommand('bold')"><i class="fas fa-bold"></i></button>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded"
                                    onclick="document.execCommand('italic')"><i class="fas fa-italic"></i></button>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded"
                                    onclick="document.execCommand('underline')"><i
                                        class="fas fa-underline"></i></button>
                                <div class="w-px h-6 bg-gray-300"></div>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded"
                                    onclick="document.execCommand('insertUnorderedList')"><i
                                        class="fas fa-list-ul"></i></button>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded"
                                    onclick="document.execCommand('insertOrderedList')"><i
                                        class="fas fa-list-ol"></i></button>
                            </div>
                            <div id="editor-content" class="editor-content p-3 min-h-[150px]" contenteditable="true">
                            </div>
                            <textarea name="isi_kursus" id="isi_kursus" class="hidden"></textarea>
                        </div>
                        @error('isi_kursus')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            <span id="btn-submit-text">Simpan Kursus</span>
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
                                Nama Kursus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mapel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kursuses as $k)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $k->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $k->nama_kursus }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $k->mapel->nama_mapel ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $k->guru->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $k->kelas->tingkat ?? '' }}
                                    {{ $k->kelas->urutan_kelas ?? '' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $k->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $k->id }}" data-nama="{{ $k->nama_kursus }}"
                                        data-mapel="{{ $k->mapel_id }}" data-guru="{{ $k->guru_id }}"
                                        data-kelas="{{ $k->kelas_id }}" data-isi="{{ $k->isi_kursus }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $k->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $kursuses->links('pagination::tailwind') }}</div>
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
        const editor = document.getElementById('editor-content');
        editor.addEventListener('input', () => document.getElementById('isi_kursus').value = editor.innerHTML);

        document.getElementById('btn-tambah').addEventListener('click', () => {
            document.getElementById('form-container').classList.toggle('hidden');
            document.getElementById('formKursus').reset();
            document.getElementById('editor-content').innerHTML = '';
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formKursus').action = "{{ route('kursus.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Kursus';
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('form-container').classList.remove('hidden');
                document.getElementById('nama_kursus').value = btn.dataset.nama;
                document.getElementById('mapel_id').value = btn.dataset.mapel;
                document.getElementById('guru_id').value = btn.dataset.guru;
                document.getElementById('kelas_id').value = btn.dataset.kelas;
                document.getElementById('editor-content').innerHTML = btn.dataset.isi;
                document.getElementById('isi_kursus').value = btn.dataset.isi;
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('formKursus').action = '/lms/dashboard/kursus/' + btn.dataset.id;
                document.getElementById('btn-submit-text').textContent = 'Update Kursus';
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
            fetch(`/lms/dashboard/kursus/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        });
    </script>
</x-baseLMSDashboard>
