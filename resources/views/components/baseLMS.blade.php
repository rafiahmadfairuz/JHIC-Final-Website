<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-[some-integrity-hash]" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-purple': '#F3F0FF',
                        'purple-main': '#8B5CF6',
                        'pastel-blue': '#EFF6FF',
                        'blue-main': '#3B82F6',
                        'pastel-orange': '#FFF7ED',
                        'orange-main': '#F97316'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            box-sizing: border-box;
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .progress-circle {
            background: conic-gradient(#8B5CF6 0deg 252deg, #E5E7EB 252deg 360deg);
        }


        /* Mobile Search Styles */
        .mobile-search-btn {
            display: none;
            padding: 8px;
            color: #6b7280;
            transition: color 0.2s;
        }

        .mobile-search-btn:hover {
            color: #8B5CF6;
        }

        .search-icon {
            width: 20px;
            height: 20px;
        }

        .mobile-search-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 60;
            flex-direction: column;
        }

        .mobile-search-container.active {
            display: flex;
        }

        .mobile-search-wrapper {
            position: relative;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .mobile-search-input {
            width: 100%;
            padding: 12px 48px 12px 40px;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            font-size: 16px;
            outline: none;
            transition: all 0.2s;
        }

        .mobile-search-input:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        .mobile-search-icon {
            position: absolute;
            left: 28px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
        }

        .mobile-search-close {
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            padding: 4px;
            color: #6b7280;
        }

        .mobile-search-close svg {
            width: 20px;
            height: 20px;
        }

        .mobile-search-results {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        .search-result-item {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f9fafb;
        }

        .search-result-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-result-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .search-result-text {
            flex: 1;
        }

        .search-result-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .search-result-desc {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .search-result-badge {
            display: inline-block;
            padding: 2px 8px;
            background-color: #f3f4f6;
            color: #6b7280;
            font-size: 10px;
            border-radius: 9999px;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }

            .sidebar-mobile.open {
                transform: translateX(0);
            }

            .mobile-search-btn {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    @if (session('badge_unlocked'))
        <div id="badge-toast"
            class="fixed bottom-5 right-5 bg-purple-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-bounce z-50">

            @php
                $badge = session('badge_unlocked');
            @endphp


            <div
                class="w-8 h-8 rounded-lg bg-purple-700 flex items-center justify-center text-white text-lg shadow-inner">
                <i class="fas fa-medal"></i>
            </div>


            <div>
                <strong>Badge Baru!</strong><br>
                {{ $badge['nama'] }}
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('badge-toast')?.remove();
            }, 4000);
        </script>
    @endif


    <x-sideBarLMS />
    <div class="md:ml-64 min-h-screen">
        <x-headerLMS />
        <main id="page-content" class="p-4 md:p-6">
            {{ $slot }}
        </main>
    </div>
    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        mobileMenu?.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-mobile');
            mobileOverlay.classList.remove('hidden');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('sidebar-mobile');
            mobileOverlay.classList.add('hidden');
        });

        mobileOverlay?.addEventListener('click', () => {
            sidebar.classList.add('sidebar-mobile');
            mobileOverlay.classList.add('hidden');
        });

        function handleSearch(event) {
            const query = event.target.value.toLowerCase().trim();
            const searchResults = document.getElementById('search-results');
            const allItems = document.querySelectorAll('.search-item');

            let visibleCount = 0;
            allItems.forEach(item => {
                const title = item.dataset.title.toLowerCase();
                const text = item.textContent.toLowerCase();
                if (title.includes(query) || text.includes(query)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (query === '' || visibleCount === 0) {
                searchResults.classList.add('hidden');
            } else {
                searchResults.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationBadge = document.getElementById('notification-badge');
            const markAllBtn = notificationDropdown.querySelector('button');

            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });

            function updateBadge() {
                const unreadCount = notificationDropdown.querySelectorAll('a .bg-orange-main').length;
                if (unreadCount === 0) notificationBadge.classList.add('hidden');
                else {
                    notificationBadge.textContent = unreadCount;
                    notificationBadge.classList.remove('hidden');
                }
            }

            markAllBtn.addEventListener('click', () => {
                notificationDropdown.querySelectorAll('a .bg-orange-main').forEach(dot => {
                    dot.classList.remove('bg-orange-main');
                    dot.classList.add('bg-gray-300');
                });
                updateBadge();
            });

            updateBadge();
        });
    </script>
</body>

</html>
