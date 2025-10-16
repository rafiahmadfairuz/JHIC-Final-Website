<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Pastikan body menggunakan font Nunito */
        body {
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        /* Kelas untuk mencegah scrolling saat sidebar terbuka di mobile */
        .overflow-hidden-safe {
            overflow: hidden;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        /* Menggunakan gradient sidebar dari input awal Anda */
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        }

        .form-gradient {
            background: linear-gradient(135deg, #e0f2fe 0%, #f8fafc 100%);
        }

        .editor-toolbar {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px;
            background: #f9fafb;
        }

        .editor-content {
            min-height: 200px;
            padding: 12px;
            border: none;
            outline: none;
            font-family: 'Nunito', sans-serif;
        }

        .drag-area {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }

        .drag-area.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>

<body class="h-full bg-gray-50">
    <div class="flex h-full lg:static">

        <!-- 1. Backdrop Overlay (Hanya muncul di mobile saat sidebar terbuka) -->
        <div id="sidebar-backdrop"
            class="fixed inset-0 z-40 bg-black opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
            aria-hidden="true">
        </div>

        <!-- Sidebar (Telah dimodifikasi untuk Responsif) -->
        <div id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 sidebar-gradient shadow-2xl
                   transform -translate-x-full transition-transform duration-300 ease-in-out
                   lg:relative lg:translate-x-0 lg:flex-shrink-0 lg:shadow-xl">

            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                        <!-- Mengganti placeholder gambar sesuai sintaks asli -->
                        <img src="{{ asset('assets/img/logo.png') }}" alt="icon"
                            class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">LMS SMK Krian 1</h1>
                        <p class="text-blue-200 text-sm">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="mt-6">
                <div class="px-4 space-y-2">

                    <!-- Jurusan -->
                    <a href="{{ route('jurusan.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('jurusan*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-building mr-3
                {{ Route::is('jurusan*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Jurusan</span>
                    </a>

                    <!-- Kelas -->
                    <a href="{{ route('kelas.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('kelas*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-door-open mr-3
                {{ Route::is('kelas*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Kelas</span>
                    </a>

                    <!-- Mata Pelajaran -->
                    <a href="{{ route('mapel.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('mapel*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-book mr-3
                {{ Route::is('mapel*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Mata Pelajaran</span>
                    </a>

                    <!-- Kursus -->
                    <a href="{{ route('kursus.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('kursus*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-chalkboard-teacher mr-3
                {{ Route::is('kursus*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Kursus</span>
                    </a>
                    <!-- Kursus -->
                    <a href="{{ route('tugas.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('tugas*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-book mr-3
                {{ Route::is('tugas*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Tugas</span>
                    </a>

                    <!-- Badge Pencapaian -->
                    <a href="{{ route('badge.index') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
            {{ Route::is('badge*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-medal mr-3
                {{ Route::is('badge*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>Badge Pencapaian</span>
                    </a>

                    <!-- List Siswa -->
                    <a href="{{ route('lms.dashboard.profile.cari') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg transition-colors group
    {{ Route::is('lms.dashboard.profile.cari*') ? 'bg-blue-700 text-white' : 'text-white hover:bg-blue-700' }}">
                        <i
                            class="fas fa-users mr-3
        {{ Route::is('lms.dashboard.profile.cari*') ? 'text-white' : 'text-blue-200 group-hover:text-white' }}">
                        </i>
                        <span>List Siswa</span>
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-item flex items-center px-3 md:px-4 py-3 mb-1 text-red-500 hover:bg-red-50 transition-all duration-200 rounded-xl">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>


                </div>
            </nav>


        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header (Telah dimodifikasi untuk menyertakan tombol toggle) -->
            <header class="sticky top-0 bg-white shadow-md border-b border-gray-200 py-3 z-30">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Tombol Toggle Sidebar (Hanya terlihat di mobile) -->
                            <button id="sidebar-toggle-btn"
                                class="text-gray-500 hover:text-blue-600 focus:outline-none mr-4 lg:hidden p-2 rounded-full transition duration-150">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h2 class="text-2xl font-bold text-gray-800">Dashboard LMS</h2>
                        </div>
                        <div class="flex items-center space-x-2 md:space-x-4">
                            <!-- User Profile -->
                            <div class="relative">
                                @php
                                    $user = Auth::user();
                                    $nama = $user->nama_lengkap ?? 'User';
                                    $words = explode(' ', trim($nama));
                                    $initials = strtoupper(
                                        substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                                    );
                                    $colors = ['purple', 'blue', 'green', 'orange', 'pink', 'teal', 'red', 'indigo'];
                                    $color = $colors[crc32($nama) % count($colors)];
                                @endphp

                                <div id="user-menu-btn"
                                    class="flex items-center space-x-2 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                    <div
                                        class="w-8 h-8 rounded-full bg-{{ $color }}-100 flex items-center justify-center text-{{ $color }}-700 font-bold text-sm">
                                        {{ $initials }}
                                    </div>
                                    <span class="font-medium text-gray-700 hidden md:block">{{ $nama }}</span>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="p-6">
                <!-- Konten utama menggunakan $slot, tidak ada perubahan -->
                {{ $slot }}
            </main>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const backdrop = document.getElementById('sidebar-backdrop');
            const body = document.body;

            // Fungsi untuk membuka/menutup sidebar
            function toggleSidebar() {
                // Periksa apakah sidebar saat ini tertutup (memiliki kelas -translate-x-full)
                const isClosed = sidebar.classList.contains('-translate-x-full');

                if (isClosed) {
                    // Buka sidebar (Mobile View)
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');

                    // Tampilkan backdrop
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-50');

                    // Nonaktifkan scrolling pada body
                    body.classList.add('overflow-hidden-safe');
                } else {
                    // Tutup sidebar (Mobile View)
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');

                    // Sembunyikan backdrop
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    backdrop.classList.remove('opacity-50');

                    // Aktifkan kembali scrolling
                    body.classList.remove('overflow-hidden-safe');
                }
            }

            // Event Listeners
            // 1. Tombol menu di klik
            toggleBtn.addEventListener('click', toggleSidebar);
            // 2. Backdrop di klik (klik di luar sidebar)
            backdrop.addEventListener('click', toggleSidebar);

            // 3. Tambahkan event listener untuk menutup sidebar saat tautan navigasi diklik (hanya di mobile)
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Cek jika ukuran layar di bawah breakpoint 'lg' (1024px)
                    if (window.innerWidth < 1024) {
                        // Pastikan tombol toggle ada dan sidebar terbuka
                        if (!sidebar.classList.contains('-translate-x-full')) {
                            toggleSidebar();
                        }
                    }
                });
            });

            // 4. Handle resize: pastikan mode mobile dinonaktifkan saat masuk ke desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    // Pastikan kelas mobile tersembunyi dihapus agar tidak mengganggu layout desktop jika sebelumnya terbuka
                    sidebar.classList.remove('-translate-x-full', 'translate-x-0');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    backdrop.classList.remove('opacity-50');
                    body.classList.remove('overflow-hidden-safe');
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll('.content-section').forEach((section, index) => {
            section.style.display = index === 0 ? 'block' : 'none';
        });

        document.querySelectorAll('.drag-area').forEach(area => {
            const input = area.querySelector('input[type="file"]');

            area.addEventListener('dragover', (e) => {
                e.preventDefault();
                area.classList.add('dragover');
            });

            area.addEventListener('dragleave', () => {
                area.classList.remove('dragover');
            });

            area.addEventListener('drop', (e) => {
                e.preventDefault();
                area.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    showPreview(area, files[0]);
                }
            });

            input.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    showPreview(area, e.target.files[0]);
                }
            });
        });

        function showPreview(area, file) {
            const reader = new FileReader();
            const input = area.querySelector('input[type="file"]'); // ambil input-nya dulu
            reader.onload = function(e) {
                area.innerHTML = `
            <div class="preview flex flex-col items-center">
                <img src="${e.target.result}" class="w-20 h-20 object-cover rounded-lg mx-auto mb-2">
                <p class="text-gray-600 text-sm">${file.name}</p>
                <button type="button" class="text-red-600 text-sm mt-1" onclick="clearPreview(this)">Hapus</button>
            </div>
        `;
                area.appendChild(input); // ⬅️ masukkan kembali input-nya biar gak hilang
            };
            reader.readAsDataURL(file);
        }


        function clearPreview(button) {
            const area = button.closest('.drag-area');
            const input = area.querySelector('input[type="file"]');
            input.value = ''; // reset file
            area.innerHTML = `
        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
        <p class="text-gray-600">Drag & drop atau klik untuk upload</p>
    `;
            area.appendChild(input); // ⬅️ jangan lupa pasang lagi input-nya
        }


        document.querySelector('.editor-content').addEventListener('input', function() {
            const textarea = document.querySelector('textarea[name="isi_kursus"]');
            textarea.value = this.innerHTML;
        });
    </script>
</body>

</html>
