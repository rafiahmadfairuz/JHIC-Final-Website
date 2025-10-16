<x-baseLMSDashboard>
    <div id="tugas" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tasks text-blue-600 mr-3"></i>
                    Manajemen Tugas
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Tugas
                </button>
            </div>

            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Tugas</h4>
                <form id="formTugas" method="POST">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="tugas_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kursus</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chalkboard-teacher text-gray-400"></i>
                                </div>
                                <select name="kursus_id" id="kursus_id"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Kursus</option>
                                    @foreach ($kursuses as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kursus }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kursus_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tugas</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tasks text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_tugas" id="nama_tugas"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama tugas">
                            </div>
                            @error('nama_tugas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Batas Pengumpulan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="batas_pengumpulan" id="batas_pengumpulan"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            @error('batas_pengumpulan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-md font-semibold text-gray-700">Soal-soal</h5>
                            <button type="button" onclick="addQuestion()"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm flex items-center">
                                <i class="fas fa-plus mr-1"></i> Tambah Soal
                            </button>
                        </div>
                        <div id="questions-container"></div>
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i> <span id="btn-submit-text">Simpan Tugas</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter Kursus -->
            <div class="flex justify-end mb-4">
                <form method="GET" class="flex items-center space-x-2">
                    <select name="filter_kursus" onchange="this.form.submit()"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kursus</option>
                        @foreach ($kursuses as $k)
                            <option value="{{ $k->id }}"
                                {{ request('filter_kursus') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kursus }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Tugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kursus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Batas Pengumpulan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($tugas as $t)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $t->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $t->nama_tugas }}</td>
                                <td class="px-6 py-4 text-sm">{{ $t->kursus->nama_kursus ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $t->batas_pengumpulan }}</td>
                                <td class="px-6 py-4 text-sm">{{ $t->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $t->id }}" data-nama="{{ $t->nama_tugas }}"
                                        data-kursus="{{ $t->kursus_id }}" data-batas="{{ $t->batas_pengumpulan }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 btn-delete"
                                        data-id="{{ $t->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $tugas->links('pagination::tailwind') }}</div>
        </div>
    </div>

    <!-- Modal Hapus -->
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
        let questionIndex = 0;

        function addQuestion(data = {}) {
            const i = questionIndex++;
            const pertanyaan = data.pertanyaan ?? '';
            const skor = data.skor ?? '';
            const jawabanBenar = data.jawaban_benar ?? '';
            const opsiA = data.opsi_a ?? '';
            const opsiB = data.opsi_b ?? '';
            const opsiC = data.opsi_c ?? '';
            const opsiD = data.opsi_d ?? '';

            const q = document.createElement('div');
            q.className = "question-item bg-gray-50 rounded-lg p-4 mb-4";
            q.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h6 class="font-medium text-gray-700">Soal <span class="num">${i + 1}</span></h6>
                <button type="button" class="text-red-600 hover:text-red-800" onclick="removeQuestion(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Pertanyaan</label>
                    <textarea name="soals[${i}][pertanyaan]" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">${pertanyaan}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    ${renderOpsi(i, 'A', opsiA, jawabanBenar)}
                    ${renderOpsi(i, 'B', opsiB, jawabanBenar)}
                    ${renderOpsi(i, 'C', opsiC, jawabanBenar)}
                    ${renderOpsi(i, 'D', opsiD, jawabanBenar)}
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Skor</label>
                    <input type="number" name="soals[${i}][skor]" value="${skor}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>`;
            document.getElementById('questions-container').appendChild(q);
            reindexQuestions();
        }

        function renderOpsi(i, huruf, value, jawabanBenar) {
            const checked = jawabanBenar === huruf ? 'checked' : '';
            return `
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Opsi ${huruf}</label>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="soals[${i}][jawaban_benar]" value="${huruf}" class="text-blue-600" ${checked}>
                    <input type="text" name="soals[${i}][opsi_${huruf.toLowerCase()}]" value="${value}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Opsi ${huruf}">
                </div>
            </div>`;
        }

        function removeQuestion(btn) {
            btn.closest('.question-item').remove();
            reindexQuestions();
        }

        function reindexQuestions() {
            const items = document.querySelectorAll('.question-item');
            items.forEach((el, idx) => {
                el.querySelector('.num').textContent = idx + 1;
            });
            questionIndex = items.length;
        }

        document.getElementById('btn-tambah').addEventListener('click', () => {
            document.getElementById('form-container').classList.toggle('hidden');
            document.getElementById('formTugas').reset();
            document.getElementById('questions-container').innerHTML = '';
            questionIndex = 0;
            addQuestion();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formTugas').action = "{{ route('tugas.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Tugas';
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', async () => {
                document.getElementById('form-container').classList.remove('hidden');
                document.getElementById('formTugas').reset();
                document.getElementById('questions-container').innerHTML = '';

                // reset index sebelum render soal
                questionIndex = 0;

                document.getElementById('tugas_id').value = btn.dataset.id;
                document.getElementById('nama_tugas').value = btn.dataset.nama;
                document.getElementById('kursus_id').value = btn.dataset.kursus;
                const rawBatas = btn.dataset.batas;
                if (rawBatas) {
                    const date = new Date(rawBatas.replace(' ', 'T')); // biar aman formatnya
                    // ambil komponen lokal
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const formatted = `${year}-${month}-${day}T${hours}:${minutes}`;
                    document.getElementById('batas_pengumpulan').value = formatted;
                    console.log(formatted); // harus 2025-10-24T01:00
                } else {
                    document.getElementById('batas_pengumpulan').value = '';
                }

                document.getElementById('form_method').value = 'PUT';
                document.getElementById('formTugas').action = '/lms/dashboard/tugas/' + btn.dataset.id;
                document.getElementById('btn-submit-text').textContent = 'Update Tugas';

                const res = await fetch(`/lms/dashboard/tugas/${btn.dataset.id}/edit`);
                const soals = await res.json();

                // reset total sebelum tambah lagi
                questionIndex = 0;
                document.getElementById('questions-container').innerHTML = '';

                soals.forEach(s => addQuestion({
                    pertanyaan: s.pertanyaan,
                    opsi_a: s.opsi_a,
                    opsi_b: s.opsi_b,
                    opsi_c: s.opsi_c,
                    opsi_d: s.opsi_d,
                    jawaban_benar: s.jawaban_benar,
                    skor: s.skor
                }));

                reindexQuestions();
            });
        });


        let deleteId = null;
        document.querySelectorAll('.btn-delete').forEach(btn => btn.onclick = () => {
            deleteId = btn.dataset.id;
            document.getElementById('deleteModal').classList.remove('hidden');
        });
        document.getElementById('cancelDelete').onclick = () => document.getElementById('deleteModal').classList.add(
            'hidden');
        document.getElementById('confirmDelete').onclick = () => {
            fetch(`/lms/dashboard/tugas/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        };
    </script>


</x-baseLMSDashboard>
