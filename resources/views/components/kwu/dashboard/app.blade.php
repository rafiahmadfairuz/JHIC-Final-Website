<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-active {
            background-color: #374151;
            color: white;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <x-kwu.dashboard.sidebar />
        <div id="mainContent" class="flex-1 lg:ml-64 transition-all duration-300">
            <x-kwu.dashboard.header />
            {{ $slot }}
        </div>
    </div>
    <script>
        const sidebar = document.getElementById("sidebar");
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebarClose = document.getElementById("sidebarClose");
        const mainContent = document.getElementById("mainContent");

        sidebarClose.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
        });

        sidebarToggle.addEventListener("click", () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle("-translate-x-full");
            } else {
                sidebar.classList.toggle("w-64");
                sidebar.classList.toggle("w-20");
                mainContent.classList.toggle("lg:ml-64");
                mainContent.classList.toggle("lg:ml-20");
                document.querySelectorAll(".sidebar-text").forEach(el => {
                    el.classList.toggle("hidden");
                });
            }
        });

        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }
        const darkModeToggle = document.getElementById("darkModeToggle");
        const html = document.documentElement;

        if (localStorage.getItem("theme") === "dark") {
            html.classList.add("dark");
        } else {
            html.classList.remove("dark");
        }

        darkModeToggle.addEventListener("click", () => {
            html.classList.toggle("dark");
            if (html.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
        const productModal = document.getElementById("productModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");
        const closeModal2 = document.getElementById("closeModal2");

        document.addEventListener('livewire:navigated', () => {
            Livewire.on('openProductModal', () => {
                document.getElementById("productModal").classList.remove("hidden");
            });

            Livewire.on('closeProductModal', () => {
                document.getElementById("productModal").classList.add("hidden");
            });
        });
        let qty = 1;
        const qtyDisplay = document.getElementById('quantity');
        const qtyInput = document.getElementById('qtyInput');

        document.getElementById('increaseQty').addEventListener('click', () => {
            qty++;
            qtyDisplay.textContent = qty;
            qtyInput.value = qty;
        });

        document.getElementById('decreaseQty').addEventListener('click', () => {
            if (qty > 1) {
                qty--;
                qtyDisplay.textContent = qty;
                qtyInput.value = qty;
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            const currentUrl = window.location.href;
            const links = document.querySelectorAll("#sidebar a");

            links.forEach(link => {
                if (link.href === currentUrl) {
                    links.forEach(l => l.classList.remove("bg-gray-700", "text-white"));

                    link.classList.add("bg-gray-700", "text-white");
                }
            });
        });
    </script>
</body>

</html>
