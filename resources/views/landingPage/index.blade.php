<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website - SMK KRIAN 1 SIDOARJO</title>
    <link rel="stylesheet" href="{{ asset('assets/css/lp.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

</head>

<body>
    <!-- Navbar -->
    <div class="navbar-wrapper" id="navbar">
        <header class="navbar">
            <!-- Logo -->
            <div class="logo">
                <img src="{{ asset('assets-landing-page/logo.png') }}" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <span class="yayasan">Yayasan Pembangunan Pendidikan</span>
                    <h1>SMK KRIAN 1</h1>
                    <h2>SIDOARJO</h2>
                </div>
            </div>

            <!-- Desktop Nav Items -->
            <div class="nav-items" style="display: flex; align-items: center; gap: 24px;">
                <div class="nav-item">
                    <a href="#info"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Info
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#fitur"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Fitur
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#guru"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Guru
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#profile"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Profile
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#jurusan"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Jurusan
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#pertanyaan"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Pertanyaan
                    </a>
                </div>

                <div class="nav-item">
                    <a href="#alumni"
                        style="color: black; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        Alumni
                    </a>
                </div>
            </div>


            @auth
                @if (auth()->user()->role === 'admin_utama')
                    <!-- Sudah login dan role admin_utama → tampil tombol profil -->
                    <a href="{{ route('profileSekolah.index') }}" class="user-icon"
                        style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                width:40px;
                height:40px;
                border-radius:50%;
                background-color:#2563eb;
                color:white;
                text-decoration:none;
                box-shadow:0 2px 6px rgba(0,0,0,0.2);
                transition:background-color 0.3s ease;
            "
                        onmouseover="this.style.backgroundColor='#1e40af'"
                        onmouseout="this.style.backgroundColor='#2563eb'">
                        <i class="fas fa-user"></i>
                    </a>
                @endif
            @else
                <!-- Belum login → tombol Login -->
                <a href="{{ route('login') }}" class="user-icon"
                    style="
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:80px;
            height:40px;
            border-radius:20px;
            background-color:#2563eb;
            color:white;
            font-weight:600;
            text-decoration:none;
            box-shadow:0 2px 6px rgba(0,0,0,0.2);
            transition:background-color 0.3s ease;
        "
                    onmouseover="this.style.backgroundColor='#1e40af'" onmouseout="this.style.backgroundColor='#2563eb'">
                    Login
                </a>
            @endauth



            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </header>
    </div>



    <!-- Main Content -->
    <section>
        <div class="main-container">
            <div class="demo-content">
                <img src="assets-landing-page/poster.png" alt="">
            </div>
    </section>

    <!-- MAIN 2 CONTENT -->
    <section class="kepsek-section" id="info">
        <!-- Statistik kiri -->
        <div class="stats-col">
            <div class="stat-card">
                <img src="{{ asset('assets-landing-page/counter-04 1.png') }}" alt="">
                <h2>{{ number_format($profile->stats_siswa ?? 0) }}+</h2>
                <p>Siswa Aktif</p>
            </div>
            <div class="stat-card">
                <img src="{{ asset('assets-landing-page/counter-02 1.png') }}" alt="">
                <h2>{{ number_format($profile->stats_jurusan ?? 0) }}+</h2>
                <p>Jurusan & Ekstra Kulikuler</p>
            </div>
        </div>

        <!-- Foto 1 MASKOT -->
        <div class="kepsek-wrapper">
            <img src="{{ asset('shape-02.png') }}" alt="" class="shape-bg">
            <img src="{{ asset('storage/' . $maskot->gambar_maskot ?? 'assets-landing-page/kepsek.png') }}"
                alt="Kepala Sekolah" class="kepsek-img">
            <div class="kepsek-info">
                <h3>{{ $maskot->nama_maskot ?? 'Nama Maskot' }}</h3>
                <p>{{ $maskot->jabatan ?? 'Kepala Sekolah SMK Krian 1 Sidoarjo' }}</p>
            </div>
        </div>

        <!-- Statistik kanan -->
        <div class="stats-col">
            <div class="stat-card">
                <img src="{{ asset('assets-landing-page/counter-03 1 (1).png') }}" alt="">
                <h2>{{ number_format($profile->stats_prestasi ?? 0) }}+</h2>
                <p>Peraih Prestasi</p>
            </div>
            <div class="stat-card">
                <img src="{{ asset('assets-landing-page/counter-01 1.png') }}" alt="">
                <h2>{{ number_format($profile->stats_alumni ?? 0) }}+</h2>
                <p>Alumni Berkompetensi</p>
            </div>
        </div>
    </section>

    <!-- Banner Sponsor -->
    <section class="banner-section">
        <div class="banner-wrapper">
            <img src="assets-landing-page/Benner3.png" alt="Banner Sponsor SMK Krian 1">
        </div>
    </section>



    <!-- SECTION FITUR -->
    <section class="fitur-section" id="fitur">
        <div class="fitur-card">
            <img src="{{ asset('assets-landing-page/Rectangle 248.png') }}" alt="LMS Siswa">
            <button class="icon-btn"><i class="fa-solid fa-arrow-right"></i></button>
            <div class="fitur-content">
                <h3>LMS Siswa</h3>
                <p>Pengelolaan belajar dari mana saja dengan fitur Tracking langsung nilainya</p>
                <a href="{{ route('lms.dashboard') }}" class="btn-fitur">Coba Sekarang</a>
            </div>
        </div>

        <div class="fitur-card">
            <img src="{{ asset('assets-landing-page/Marketplace.png') }}" alt="Marketplace">
            <button class="icon-btn"><i class="fa-solid fa-arrow-right"></i></button>
            <div class="fitur-content">
                <h3>Marketplace</h3>
                <p>Temukan produk karya siswa dengan sistem jual beli modern</p>
                <a href="{{ route('landing.kwu.index') }}" class="btn-fitur">Coba Sekarang</a>
            </div>
        </div>

        <div class="fitur-card">
            <img src="{{ asset('assets-landing-page/Rectangle 329.png') }}" alt="Job Fair">
            <button class="icon-btn"><i class="fa-solid fa-arrow-right"></i></button>
            <div class="fitur-content">
                <h3>Job Fair</h3>
                <p>Koneksi langsung dunia kerja dengan peluang rekrutmen</p>
                <a href="{{ route('jobfair.landing') }}" class="btn-fitur">Coba Sekarang</a>
            </div>
        </div>
    </section>

    <!-- SECTION GURU -->
    <section class="guru-section" id="guru">
        <h2 class="guru-title">Guru Inspirasi</h2>
        <div class="guru-wrapper">
            <!-- Guru Utama -->
            @if ($gurus->count())
                @php $guruUtama = $gurus->first(); @endphp
                <div class="guru-main" id="guruMain">
                    <img src="{{ asset('storage/' . $guruUtama->guru_img) }}" alt="Guru Utama" id="guruMainImg">
                    <div class="guru-info">
                        <h3 id="guruMainName">{{ $guruUtama->nama_guru }}</h3>
                        <p id="guruMainRole">{{ $guruUtama->jabatan_guru }}</p>
                    </div>
                </div>
            @endif

            <!-- Guru Lain -->
            <div class="guru-grid">
                @foreach ($gurus as $g)
                    <div class="guru-card" data-name="{{ $g->nama_guru }}" data-role="{{ $g->jabatan_guru }}"
                        data-img="{{ asset('storage/' . $g->guru_img) }}">
                        <img src="{{ asset('storage/' . $g->guru_img) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION PROFILE SEKOLAH -->
    <section class="profile-section" id="profile">
        <h2 class="profile-title">Profile Sekolah</h2>
        <div class="wave-bg">
            <img src="{{ asset('assets-landing-page/Vector.png') }}" alt="Wave 1" class="wave wave1">
            <img src="{{ asset('assets-landing-page/Vector (1).png') }}" alt="Wave 2" class="wave wave2">
        </div>

        <div class="video-container">
            <div class="video-wrapper">
                <img src="{{ asset('storage/' . $profile->banner_img ?? 'assets-landing-page/tumblail.png') }}"
                    alt="Profile Sekolah" class="video-thumbnail">
                <a href="{{ $profile->link_video ?? '#' }}" target="_blank" class="play-btn">▶</a>
            </div>
        </div>
    </section>

    <section class="jurusan-section" id="jurusan">
        <div class="jurusan-header">
            <img src="{{ asset('assets-landing-page/Poster2.png') }}" alt="Jurusan Populer" class="poster-img">
        </div>

        <div class="jurusan-grid">
            @foreach ($jurusans->chunk(3) as $chunkIndex => $chunk)
                <div class="row">
                    @foreach ($chunk as $j)
                        <div class="jurusan-card {{ $loop->first && $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="card-header">
                                <span class="dot red"></span>
                                <span class="dot yellow"></span>
                                <span class="dot green"></span>
                            </div>

                            @if ($j->gambar_jurusan)
                                <img src="{{ asset('storage/' . $j->gambar_jurusan) }}"
                                    alt="{{ $j->nama_jurusan }}">
                            @else
                                <img src="{{ asset('assets-landing-page/default-jurusan.png') }}" alt="default">
                            @endif

                            <h3>{{ $j->nama_jurusan }}</h3>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>


    <!-- SECTION FAQ -->
    <section class="faq-section" id="pertanyaan">
        <h2 class="faq-title">Pertanyaan <span>Yang Sering</span> Ditanyakan</h2>
        @foreach ($pertanyaans as $index => $p)
            <div class="faq-item">
                <div class="faq-question">
                    <span class="faq-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="faq-text">{{ $p->judul }}</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    {!! nl2br(e($p->jawaban)) !!}
                </div>
            </div>
        @endforeach
    </section>

    <!-- SECTION ALUMNI -->
    <section class="alumni-section" id="alumni">
        <h2 class="alumni-title">Apa <span>Kata</span> Alumni</h2>
        <p class="alumni-subtitle">Lihat bagaimana testimoni alumni SMK Krian 1 yang sekarang bekerja atau berkuliah
        </p>

        <div class="alumni-row row-1">
            <div class="alumni-track">
                @foreach ($alumnis as $a)
                    <div class="alumni-card">
                        @php
                            $inisial = strtoupper(substr($a->nama, 0, 1));
                        @endphp

                        @if (!empty($a->gambar))
                            <img src="{{ asset('storage/' . $a->gambar) }}" alt="{{ $a->nama }}"
                                class="w-16 h-16 rounded-full object-cover border-2 border-blue-500 shadow-md">
                        @else
                            <div
                                class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600
                text-white flex items-center justify-center text-xl font-bold
                shadow-md border-2 border-white">
                                {{ $inisial }}
                            </div>
                        @endif

                        <h4 class="mt-2 text-gray-800 font-semibold">{{ $a->nama }}</h4>

                        <p>{{ $a->jurusan }}</p>
                        <small>“{{ $a->keterangan }}”</small>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

            mobileMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
        }

        // Toggle submenu in mobile
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            const chevron = element.querySelector('.chevron');

            // Close other open submenus
            const allSubmenus = document.querySelectorAll('.mobile-nav-submenu');
            const allChevrons = document.querySelectorAll('.mobile-nav-item .chevron');
            const allItems = document.querySelectorAll('.mobile-nav-item');

            allSubmenus.forEach(sub => {
                if (sub !== submenu) {
                    sub.classList.remove('expanded');
                }
            });

            allChevrons.forEach(chev => {
                if (chev !== chevron) {
                    chev.parentElement.classList.remove('expanded');
                }
            });

            // Toggle current submenu
            submenu.classList.toggle('expanded');
            element.classList.toggle('expanded');
        }

        // Handle user click in mobile sidebar
        function handleUserClick() {
            alert('User profile clicked! Di sini bisa redirect ke halaman profil user.');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');

            if (!mobileMenu.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                mobileMenu.classList.remove('active');
                document.getElementById('mobileMenuOverlay').classList.remove('active');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('mobileMenu').classList.remove('active');
                document.getElementById('mobileMenuOverlay').classList.remove('active');
            }
        });

        // Navbar scroll effect
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const navbar = document.getElementById('navbar');

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            lastScrollTop = scrollTop;
        });

        const guruCards = document.querySelectorAll('.guru-card');
        const guruMain = document.getElementById('guruMain');
        const mainImg = document.getElementById('guruMainImg');
        const mainName = document.getElementById('guruMainName');
        const mainRole = document.getElementById('guruMainRole');

        guruCards.forEach(card => {
            card.addEventListener('click', () => {
                const img = card.getAttribute('data-img');
                const name = card.getAttribute('data-name');
                const role = card.getAttribute('data-role');

                // animasi fade-out
                guruMain.classList.add('fade');
                setTimeout(() => {
                    mainImg.src = img;
                    mainName.textContent = name;
                    mainRole.textContent = role;

                    guruMain.classList.remove('fade'); // fade-in lagi
                    guruMain.classList.add('active');

                    setTimeout(() => guruMain.classList.remove('active'), 500);
                }, 300);
            });
        });



        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const toggle = item.querySelector('.faq-toggle');

            question.addEventListener('click', () => {
                const isActive = answer.classList.contains('active');

                // Tutup semua dulu
                document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('active'));
                document.querySelectorAll('.faq-toggle').forEach(t => t.classList.remove('active'));

                // Kalau sebelumnya tidak aktif, buka yang diklik
                if (!isActive) {
                    answer.classList.add('active');
                    toggle.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
