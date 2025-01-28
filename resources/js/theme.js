document.addEventListener('DOMContentLoaded', function () {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');


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
        userDropdown.classList.toggle('hidden');
    });

    // hidden when click on anything
    document.addEventListener('click', (event) => {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
    });

    /*Toggle sidebar hide/show*/
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth >= 1024) {
            // Jika layar besar, toggle class untuk menyembunyikan teks menu
            sidebar.classList.toggle('sidebar-collapsed');
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
