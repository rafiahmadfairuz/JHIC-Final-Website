<x-baseDashboard>
    <div id="profile-sekolah" class="content-section">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-school text-blue-600 mr-3"></i> Manajemen Profil Sekolah
                </h3>
                <button id="btn-tambah"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </button>
            </div>

            <div class="form-gradient rounded-lg p-6 mb-6 hidden" id="form-container">
                <h4 class="text-lg font-semibold text-gray-700 mb-4" id="form-title">Form Profil Sekolah</h4>
                <form id="formProfile" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="profile_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banner Sekolah</label>
                            <div class="drag-area rounded-lg p-6 text-center cursor-pointer border border-gray-300"
                                onclick="document.getElementById('banner_img').click()">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Drag & drop atau klik untuk upload banner</p>
                                <input type="file" id="banner_img" name="banner_img" class="hidden" accept="image/*">
                                <div id="bannerPreview" class="mt-3 hidden">
                                    <img id="previewImg" src="" class="rounded-lg w-full h-48 object-cover">
                                </div>
                            </div>
                            @error('banner_img')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Siswa</label>
                            <input type="number" name="stats_siswa" id="stats_siswa"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stats_siswa')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Jurusan</label>
                            <input type="number" name="stats_jurusan" id="stats_jurusan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stats_jurusan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Alumni</label>
                            <input type="number" name="stats_alumni" id="stats_alumni"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stats_alumni')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Prestasi</label>
                            <input type="number" name="stats_prestasi" id="stats_prestasi"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stats_prestasi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Video Profil</label>
                            <input type="text" name="link_video" id="link_video"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="https://youtube.com/...">
                            @error('link_video')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i> <span id="btn-submit-text">Simpan Profil</span>
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
                                Banner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alumni</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prestasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Video</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($profile)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $profile->id }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($profile->banner_img)
                                        <img src="{{ asset('storage/' . $profile->banner_img) }}"
                                            class="w-16 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-16 h-10 bg-gray-200 rounded-lg"></div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $profile->stats_siswa }}</td>
                                <td class="px-6 py-4 text-sm">{{ $profile->stats_jurusan }}</td>
                                <td class="px-6 py-4 text-sm">{{ $profile->stats_alumni }}</td>
                                <td class="px-6 py-4 text-sm">{{ $profile->stats_prestasi }}</td>
                                <td class="px-6 py-4 text-sm truncate max-w-[160px]">{{ $profile->link_video }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit"
                                        data-id="{{ $profile->id }}" data-siswa="{{ $profile->stats_siswa }}"
                                        data-jurusan="{{ $profile->stats_jurusan }}"
                                        data-alumni="{{ $profile->stats_alumni }}"
                                        data-prestasi="{{ $profile->stats_prestasi }}"
                                        data-link="{{ $profile->link_video }}"
                                        data-banner="{{ $profile->banner_img }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">Belum ada data profil
                                    sekolah</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
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
        const preview = document.getElementById('bannerPreview');
        const img = document.getElementById('previewImg');
        document.getElementById('banner_img').addEventListener('change', e => {
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
            document.getElementById('formProfile').reset();
            document.getElementById('form_method').value = 'POST';
            document.getElementById('formProfile').action = "{{ route('profileSekolah.store') }}";
            document.getElementById('btn-submit-text').textContent = 'Simpan Profil';
            preview.classList.add('hidden');
        };

        document.querySelectorAll('.btn-edit').forEach(btn => btn.onclick = () => {
            document.getElementById('form-container').classList.remove('hidden');
            document.getElementById('formProfile').reset();
            document.getElementById('profile_id').value = btn.dataset.id;
            document.getElementById('stats_siswa').value = btn.dataset.siswa;
            document.getElementById('stats_jurusan').value = btn.dataset.jurusan;
            document.getElementById('stats_alumni').value = btn.dataset.alumni;
            document.getElementById('stats_prestasi').value = btn.dataset.prestasi;
            document.getElementById('link_video').value = btn.dataset.link;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('formProfile').action = '/dashboardLanding/profileSekolah/' + btn.dataset.id;
            document.getElementById('btn-submit-text').textContent = 'Update Profil';
            if (btn.dataset.banner) {
                img.src = '/storage/' + btn.dataset.banner;
                preview.classList.remove('hidden');
            }
        });
    </script>
</x-baseDashboard>
