<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kewirausahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body class="bg-gradient-to-b from-blue-50 to-[#f4f6fb] ">
    <x-kwu.landing.nav />
    <div>
        {{ $slot }}
    </div>
    <x-kwu.landing.footer />
    <script>
        document
            .getElementById("sortSelect")
            .addEventListener("change", function() {
                alert("Sort selected: " + this.value);
            });

        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");
        const closeMenu = document.getElementById("close-menu");

        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.remove("hidden");
        });
        closeMenu.addEventListener("click", () => {
            mobileMenu.classList.add("hidden");
        });

        const quantityEl = document.getElementById("quantity");
        const increaseBtn = document.getElementById("increaseQty");
        const decreaseBtn = document.getElementById("decreaseQty");

        let quantity = 1;

        increaseBtn.addEventListener("click", () => {
            quantity++;
            quantityEl.textContent = quantity;
        });

        decreaseBtn.addEventListener("click", () => {
            if (quantity > 1) {
                quantity--;
                quantityEl.textContent = quantity;
            }
        });

        const tabButtons = document.querySelectorAll(".tab-btn");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                tabButtons.forEach(b => {
                    b.classList.remove("border-b-2", "border-indigo-500", "text-indigo-500");
                    b.classList.add("text-gray-500");
                });
                tabContents.forEach(content => content.classList.add("hidden"));

                btn.classList.add("border-b-2", "border-indigo-500", "text-indigo-500");
                btn.classList.remove("text-gray-500");
                document.getElementById(btn.dataset.tab).classList.remove("hidden");
            });
        });
    </script>
</body>

</html>
