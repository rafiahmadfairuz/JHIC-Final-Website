<x-baseDashboard>
    <div id="alumni" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-user-graduate text-blue-600 mr-3"></i> Manajemen Alumni
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Alumni
                </button>
            </div>

            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Alumni</h4>
                <form id="formAlumni" method="POST">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="alumni_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Alumni</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="nama" id="nama"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama alumni">
                            </div>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tools text-gray-400"></i>
                                </div>
                                <input type="text" name="jurusan" id="jurusan"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Contoh: Rekayasa Perangkat Lunak">
                            </div>
                            @error('jurusan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Alumni</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="alumni_tahun" id="alumni_tahun"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Contoh: 2023">
                            </div>
                            @error('alumni_tahun')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-star text-gray-400"></i>
                                </div>
                                <input type="number" name="rating" id="rating" min="1" max="5"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Nilai 1 - 5">
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-comment text-gray-400"></i>
                                </div>
                                <textarea name="keterangan" id="keterangan" rows="4"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Tuliskan deskripsi singkat atau testimoni..."></textarea>
                            </div>
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i> <span id="btn-submit-text">Simpan Alumni</span>
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
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($alumnis as $a)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $a->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $a->nama }}</td>
                                <td class="px-6 py-4 text-sm">{{ $a->jurusan }}</td>
                                <td class="px-6 py-4 text-sm">{{ $a->alumni_tahun }}</td>
                                <td class="px-6 py-4 text-sm text-yellow-500">
                                    @for ($i = 0; $i < $a->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </td>
                                <td class="px-6 py-4 text-sm max-w-xs truncate">{{ $a->keterangan }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $a->id }}" data-nama="{{ $a->nama }}"
                                        data-jurusan="{{ $a->jurusan }}" data-tahun="{{ $a->alumni_tahun }}"
                                        data-keterangan="{{ $a->keterangan }}" data-rating="{{ $a->rating }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $a->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $alumnis->links('pagination::tailwind') }}</div>
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
        document.getElementById('btn-tambah').onclick = () => {
            const f = document.getElementById('form-container');
            f.classList.toggle('hidden');
            document.getElementById('formAlumni').reset();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formAlumni').action = "{{ route('alumni.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Alumni';
        };

        document.querySelectorAll('.btn-edit').forEach(btn => btn.onclick = () => {
            document.getElementById('form-container').classList.remove('hidden');
            document.getElementById('formAlumni').reset();
            document.getElementById('alumni_id').value = btn.dataset.id;
            document.getElementById('nama').value = btn.dataset.nama;
            document.getElementById('jurusan').value = btn.dataset.jurusan;
            document.getElementById('alumni_tahun').value = btn.dataset.tahun;
            document.getElementById('keterangan').value = btn.dataset.keterangan;
            document.getElementById('rating').value = btn.dataset.rating;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('formAlumni').action = '/dashboardLanding/alumni/' + btn.dataset.id;
            document.getElementById('btn-submit-text').textContent = 'Update Alumni';
        });

        let delId = null;
        document.querySelectorAll('.btn-delete').forEach(btn => btn.onclick = () => {
            delId = btn.dataset.id;
            document.getElementById('deleteModal').classList.remove('hidden');
        });
        document.getElementById('cancelDelete').onclick = () => document.getElementById('deleteModal').classList.add(
            'hidden');
        document.getElementById('confirmDelete').onclick = () => {
            fetch('/dashboardLanding/alumni/' + delId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        };
    </script>
</x-baseDashboard>
