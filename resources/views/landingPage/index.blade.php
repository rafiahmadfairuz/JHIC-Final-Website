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
    <!-- ========================= -->
    <!-- NAVBAR -->
    <!-- ========================= -->
    <div class="navbar-wrapper" id="navbar">
        <header class="navbar">
            <!-- LOGO -->
            <div class="logo">
                <img src="{{ asset('assets-landing-page/logo.png') }}" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <span class="yayasan">Yayasan Pembangunan Pendidikan</span>
                    <h1>SMK KRIAN 1</h1>
                    <h2>SIDOARJO</h2>
                </div>
            </div>

            <!-- NAV ITEMS (DESKTOP) -->
            <div class="nav-items">
                <a href="#info" class="nav-item">Info</a>
                <a href="#fitur" class="nav-item">Fitur</a>
                <a href="#guru" class="nav-item">Guru</a>
                <a href="#profile" class="nav-item">Profile</a>
                <a href="#jurusan" class="nav-item">Jurusan</a>
                <a href="#pertanyaan" class="nav-item">Pertanyaan</a>
                <a href="#alumni" class="nav-item">Alumni</a>
            </div>

            <!-- USER ICON (DESKTOP) -->
            @auth
                @if (auth()->user()->role === 'admin_utama')
                    <a href="{{ route('profileSekolah.index') }}" class="user-icon" title="Admin Utama">
                        <i class="fas fa-user-shield"></i>
                    </a>
                @elseif (auth()->user()->role === 'admin_perpus')
                    <a href="{{ route('perpus.dashboard') }}" class="user-icon" title="Admin Perpustakaan">
                        <i class="fas fa-book"></i>
                    </a>
                @elseif (auth()->user()->role === 'admin_bkk')
                    <a href="{{ route('bkk.dashboard') }}" class="user-icon" title="Admin BKK">
                        <i class="fas fa-briefcase"></i>
                    </a>
                @elseif (auth()->user()->role === 'siswa')
                    <div class="user-icon" title="Siswa">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                @else
                    <div class="user-icon" title="Pengguna">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="user-icon" title="Login">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            @endauth


            <!-- MOBILE MENU BUTTON -->
            <button class="mobile-menu-toggle" id="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </header>
    </div>

    <!-- ========================= -->
    <!-- MOBILE SIDEBAR MENU -->
    <!-- ========================= -->
    <div class="mobile-menu-overlay" id="menu-overlay"></div>

    <div class="mobile-menu" id="mobile-menu">
        <button class="mobile-menu-close" id="menu-close">
            <i class="fas fa-times"></i>
        </button>

        <div class="mobile-menu-content">
            <div class="mobile-nav-section">
                <a href="#info" class="mobile-nav-item"><i class="fas fa-info-circle"></i> Info</a>
                <a href="#fitur" class="mobile-nav-item"><i class="fas fa-cogs"></i> Fitur</a>
                <a href="#guru" class="mobile-nav-item"><i class="fas fa-user-graduate"></i> Guru</a>
                <a href="#profile" class="mobile-nav-item"><i class="fas fa-school"></i> Profile</a>
                <a href="#jurusan" class="mobile-nav-item"><i class="fas fa-tools"></i> Jurusan</a>
                <a href="#pertanyaan" class="mobile-nav-item"><i class="fas fa-question-circle"></i> Pertanyaan</a>
                <a href="#alumni" class="mobile-nav-item"><i class="fas fa-users"></i> Alumni</a>
            </div>

            <!-- USER SECTION -->
            @auth
                <div class="mobile-user-info">
                    <div class="user-icon">
                        @switch(auth()->user()->role)
                            @case('admin_utama')
                                <i class="fas fa-user-shield"></i>
                            @break

                            @case('admin_perpus')
                                <i class="fas fa-book"></i>
                            @break

                            @case('admin_bkk')
                                <i class="fas fa-briefcase"></i>
                            @break

                            @case('siswa')
                                <i class="fas fa-user-graduate"></i>
                            @break

                            @default
                                <i class="fas fa-user"></i>
                        @endswitch
                    </div>
                    <div>
                        <div class="user-label">{{ auth()->user()->nama_lengkap }}</div>
                        <div class="user-subtitle">
                            @switch(auth()->user()->role)
                                @case('admin_utama')
                                    Admin Utama
                                @break

                                @case('admin_perpus')
                                    Admin Perpustakaan
                                @break

                                @case('admin_bkk')
                                    Admin BKK
                                @break

                                @case('siswa')
                                    Siswa
                                @break

                                @default
                                    Pengguna
                            @endswitch
                        </div>
                    </div>
                </div>
            @else
                <div class="mobile-user-info" onclick="window.location='{{ route('login') }}'">
                    <div class="user-icon"><i class="fas fa-sign-in-alt"></i></div>
                    <div>
                        <div class="user-label">Login</div>
                        <div class="user-subtitle">Masuk ke akunmu</div>
                    </div>
                </div>
            @endauth
        </div>
    </div>


    <!-- ========================= -->
    <!-- SCRIPT -->
    <!-- ========================= -->
    <script>
        const menuBtn = document.getElementById("menu-btn");
        const menu = document.getElementById("mobile-menu");
        const overlay = document.getElementById("menu-overlay");
        const closeBtn = document.getElementById("menu-close");

        menuBtn.addEventListener("click", () => {
            menu.classList.add("active");
            overlay.classList.add("active");
        });

        closeBtn.addEventListener("click", () => {
            menu.classList.remove("active");
            overlay.classList.remove("active");
        });

        overlay.addEventListener("click", () => {
            menu.classList.remove("active");
            overlay.classList.remove("active");
        });
    </script>





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



            <!-- Gambar Kepala Sekolah / Maskot -->
            <img src="{{ asset(isset($maskot) && $maskot->gambar_maskot ? 'storage/' . $maskot->gambar_maskot : 'assets-landing-page/kepsek.png') }}"
                alt="Foto Kepala Sekolah" class="kepsek-img">

            <!-- Info Kepala Sekolah -->
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
            <div class="video-wrapper" id="videoWrapper">
                <!-- Thumbnail -->
                <img src="{{ asset(isset($profile) && $profile->banner_img ? 'storage/' . $profile->banner_img : 'assets-landing-page/t.png') }}"
                    alt="Thumbnail" class="thumbnail">

                <!-- Tombol Play -->
                <a href="{{ $profile->link_video ?? '#' }}" class="play-btn" id="playBtn">▶</a>
            </div>
        </div>
    </section>

    <style>
        .profile-section {
            position: relative;
            text-align: center;
            overflow: hidden;
            padding: 100px 20px;
        }

        .wave-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .wave-bg .wave {
            position: absolute;
            width: 100%;
            opacity: 0.7;
        }

        .video-container {
            position: relative;
            z-index: 2;
        }

        .video-wrapper {
            position: relative;
            display: inline-block;
            max-width: 600px;
            width: 90%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .video-wrapper img.thumbnail {
            width: 100%;
            display: block;
            border-radius: 16px;
        }

        .play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            color: black;
            font-size: 32px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .play-btn:hover {
            transform: translate(-50%, -50%) scale(1.1);
        }
    </style>

    <script>
        document.getElementById("playBtn").addEventListener("click", function(event) {
            event.preventDefault(); // biar gak buka tab baru

            const wrapper = document.getElementById("videoWrapper");
            const youtubeLink = this.getAttribute("href"); // ambil dari link admin
            const videoId = youtubeLink.includes("v=") ?
                youtubeLink.split("v=")[1].split("&")[0] :
                youtubeLink.split("/").pop();

            // ganti isi wrapper jadi iframe YouTube
            wrapper.innerHTML = `
    <iframe
      width="100%" height="340"
      src="https://www.youtube.com/embed/${videoId}?autoplay=1"
      title="Video Profile Sekolah"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
      style="border-radius:16px;">
    </iframe>
  `;
        });
    </script>


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
        <p class="alumni-subtitle">
            Lihat bagaimana testimoni alumni SMK Krian 1 yang sekarang bekerja atau berkuliah
        </p>

        <div class="alumni-row row-1">
            <div class="alumni-track">
                <style>
                    .alumni-card {
                        width: 550px;
                        height: 220px;
                        background: #fff;
                        border-radius: 12px;
                        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        padding: 16px;
                        overflow: hidden;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: start;
                    }

                    .alumni-img,
                    .alumni-initial {
                        width: 64px;
                        height: 64px;
                        border-radius: 50%;
                        object-fit: cover;
                        margin-bottom: 12px;
                        border: 2px solid #fff;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                    }

                    .alumni-initial {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 20px;
                        font-weight: bold;
                        color: white;
                    }

                    .alumni-name {
                        font-weight: 600;
                        color: #333;
                        font-size: 16px;
                        margin: 0;
                        width: 100%;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    .alumni-jurusan {
                        color: #666;
                        font-size: 14px;
                        margin: 4px 0;
                        width: 100%;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    .alumni-desc {
                        color: #777;
                        font-size: 13px;
                        font-style: italic;
                        margin-top: 6px;
                        max-height: 38px;
                        /* kira-kira 2 baris */
                        overflow: hidden;
                        text-overflow: ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                    }

                    /* warna background avatar */
                    .bg-purple {
                        background: #c084fc;
                    }

                    .bg-blue {
                        background: #60a5fa;
                    }

                    .bg-green {
                        background: #4ade80;
                    }

                    .bg-orange {
                        background: #fb923c;
                    }

                    .bg-pink {
                        background: #f472b6;
                    }

                    .bg-teal {
                        background: #2dd4bf;
                    }

                    .bg-red {
                        background: #f87171;
                    }

                    .bg-indigo {
                        background: #818cf8;
                    }
                </style>

                @foreach ($alumnis as $a)
                    @php
                        $inisial = strtoupper(substr($a->nama, 0, 1));
                        $colors = ['purple', 'blue', 'green', 'orange', 'pink', 'teal', 'red', 'indigo'];
                        $color = $colors[crc32($a->nama) % count($colors)];
                    @endphp

                    <div class="alumni-card">
                        @if (!empty($a->gambar))
                            <img src="{{ asset('storage/' . $a->gambar) }}" alt="{{ $a->nama }}"
                                class="alumni-img">
                        @else
                            <div class="alumni-initial bg-{{ $color }}">
                                {{ $inisial }}
                            </div>
                        @endif

                        <h4 class="alumni-name">{{ $a->nama }}</h4>
                        <p class="alumni-jurusan">{{ $a->jurusan }}</p>
                        <small class="alumni-desc">“{{ $a->keterangan }}”</small>
                    </div>
                @endforeach

            </div>
        </div>
    </section>




    <footer class="footer">
        <div class="footer-container">
            <!-- KIRI -->
            <div class="footer-left">
                <img src="{{ asset('assets-landing-page/logo.png') }}" alt="Logo" class="logo-img">
                <h3>SMK KRIAN 1</h3>
                <p class="tagline">#TerbaikTerdepanSikat</p>
                <p class="desc">
                    Mencetak generasi unggul yang siap kerja, siap kuliah, dan siap bersaing secara global.
                </p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.instagram.com/smkkrian1/"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.tiktok.com/@skarisabisa"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- TENGAH -->
            <div class="footer-center">
                <h4>Menu Navigasi</h4>
                <ul>
                    <li><a href="#info">Info</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#guru">Guru</a></li>
                    <li><a href="#profile">Profil</a></li>
                    <li><a href="#jurusan">Jurusan</a></li>
                    <li><a href="#pertanyaan">Pertanyaan</a></li>
                    <li><a href="#alumni">Alumni</a></li>
                </ul>
            </div>

            <!-- KANAN -->
            <div class="footer-right">
                <h4>Lokasi Kami</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.312408367175!2d112.5846!3d-7.4207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e1f2147a07cb%3A0xd09c70f28775b49b!2sSMK%20Krian%201%20Sidoarjo!5e0!3m2!1sid!2sid!4v1730050000000!5m2!1sid!2sid"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        <div class="footer-bottom">
            <p>©2025 <strong>SMK KRIAN 1</strong> | Designed by <strong>Unexpected Loop</strong></p>
        </div>
    </footer>



    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>






    <script>
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
