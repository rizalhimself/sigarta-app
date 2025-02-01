document.addEventListener('DOMContentLoaded', function () {
    // toggle theme navbar
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // toggle greeting sidebar
    const greetingElement = document.getElementById("greeting");
    const greetingSection = document.getElementById("greeting-section");
    const hour = new Date().getHours();

    /*toggle submenu kependudukan*/
    const kependudukanToggle = document.getElementById("kependudukan-dropdown-toggle");
    const kependudukanDropdown = document.getElementById("kependudukan-dropdown");
    const kependudukanIcon = document.getElementById("kependudukan-icon");

    kependudukanToggle.addEventListener("click", () => {
        kependudukanDropdown.classList.toggle("hidden");

        if (kependudukanDropdown.classList.contains("active")){
            kependudukanDropdown.classList.remove("active");
            kependudukanDropdown.style.maxHeight = "0";
            document.body.style.height = "auto";

        } else {
            kependudukanDropdown.classList.add("active");
            kependudukanDropdown.style.maxHeight = kependudukanDropdown.scrollHeight + "px";
            document.body.style.height = sidebar.scrollHeight + "px";

        }
        kependudukanIcon.classList.toggle("rotate-180");

        // Pastikan sidebar tetap full height saat submenu terbuka
        sidebar.style.minHeight = "calc(100vh - 3.5rem)";

    })

    /*Greeting Function Pada Sidebar*/
    let greetingText = "Selamat Datang";
    const userName = greetingElement.getAttribute("data-username");
    if (hour >= 5 && hour < 12) {
        greetingText = "Selamat Pagi";
    } else if (hour >= 12 && hour < 15) {
        greetingText = "Selamat Siang";
    } else if (hour >= 15 && hour < 18) {
        greetingText = "Selamat Sore";
    } else {
        greetingText = "Selamat Malam";
    }

    // tambahkan greeting element pada html
    greetingElement.textContent = `${greetingText}, ${userName}`;


    /*Cek dark mode dari localStorage*/
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
        darkIcon.classList.add('hidden');
        lightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        lightIcon.classList.add('hidden');
        darkIcon.classList.remove('hidden');
    }

    /*Toggle theme on click*/
    themeToggleBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');

        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        } else {
            localStorage.setItem('theme', 'light');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
        }
    });

    /*User Dropdown*/
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    userMenuButton.addEventListener('click', () => {
        if (userDropdown.classList.contains('hidden')) {
            userDropdown.classList.remove('hidden');
            setTimeout(() => {
                userDropdown.classList.add('translate-y-0');
                userDropdown.classList.remove('-translate-y-full');
            }, 10); // delay agar tailwind dapat menangkap perubahan
        } else {
            userDropdown.classList.add('-translate-y-full');
            userDropdown.classList.remove('translate-y-0');

            // tunggu transisi selesai sebelum menyembunyikan elemen
            setTimeout(() => {
                userDropdown.classList.add('hidden');
            }, 300); // waktu transisi sesuai dengan tailwind (300ms)
        }
    });

    // hidden when click on anything
    document.addEventListener('click', (event) => {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('-translate-y-full');
            userDropdown.classList.remove('translate-y-0');

            // tunggu transisi selesai sebelum menyembunyikan elemen
            setTimeout(() => {
                userDropdown.classList.add('hidden');
            }, 300); // waktu transisi sesuai dengan tailwind (300ms)
        }
    });

    /*Toggle sidebar hide/show*/
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth >= 1024) {
            // Jika layar besar, toggle class untuk menyembunyikan teks menu
            sidebar.classList.toggle('sidebar-collapsed');
            greetingSection.classList.toggle('hidden');
        } else {
            // Jika layar kecil, sembunyikan sidebar sepenuhnya
            sidebar.classList.toggle('-translate-x-full');
        }
    })
    // collapse when click on anything on small screen
    document.addEventListener('click', (event) => {
        if (!sidebarToggle.contains(event.target) && !sidebar.contains(event.target)) {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }
        }
    })
});
