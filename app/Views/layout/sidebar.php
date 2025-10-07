<!-- app/Views/layout/sidebar.php -->

<aside class="flex flex-col h-full bg-white shadow-sm">
    <!-- Bagian Profil Pengguna -->
    <div class="flex flex-col items-center p-4 md:p-6 text-center border-b border-gray-200">
        <img
            id="profileImage"
            src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto')) . '?t=' . time()) ?>"
            alt="Foto Profil"
            class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover select-none cursor-pointer
                   ring-4 ring-offset-2 ring-offset-white ring-yellow-400 transition-all duration-300 transform hover:scale-105">
        <div class="mt-4">
            <p class="text-base md:text-lg font-bold text-gray-800 leading-tight">
                Hallo, <?= esc(session()->get('username')) ?>
            </p>
            <div class="flex items-center justify-center mt-1 space-x-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-md ring-1 ring-green-200"></span>
                <span class="text-xs sm:text-sm text-gray-600 font-medium">Online</span>
            </div>
        </div>
    </div>

    <!-- Menu Navigasi Utama -->
    <nav class="flex-grow p-3 md:p-4">
        <ul class="space-y-2" role="menu">
            <li role="none">
                <a href="<?= site_url('dashboard') ?>"
                    role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                          <?= ($active_menu ?? '') === 'dashboard' ? 'bg-yellow-400 text-black font-semibold shadow-md' : 'text-gray-700 hover:bg-yellow-100 hover:text-black' ?>">
                    <i class="fa-solid fa-house w-5 text-center text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm md:text-base">Dashboard</span>
                </a>
            </li>

            <!-- MENU SURAT KELUAR (IKON DIPERBARUI) -->
            <li role="none">
                <a href="<?= site_url('prodi') ?>"
                    role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                          <?= ($active_menu ?? '') === 'prodi' ? 'bg-yellow-400 text-black font-semibold shadow-md' : 'text-gray-700 hover:bg-yellow-100 hover:text-black' ?>">
                    <i class="fa-solid fa-paper-plane w-5 text-center text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm md:text-base">Surat Prodi</span>
                </a>
            </li>

            <li role="none">
                <a href="<?= site_url('fakultas') ?>"
                    role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                          <?= ($active_menu ?? '') === 'fakultas' ? 'bg-yellow-400 text-black font-semibold shadow-md' : 'text-gray-700 hover:bg-yellow-100 hover:text-black' ?>">
                    <i class="fa-solid fa-paper-plane w-5 text-center text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm md:text-base">Surat Fakultas</span>
                </a>
            </li>


        </ul>
    </nav>

    <!-- Menu Bagian Bawah (Akun & Logout) -->
    <div class="p-3 md:p-4 mt-auto border-t border-gray-200">
        <ul class="space-y-2" role="menu">
            <li role="none">
                <a href="<?= site_url('akun') ?>"
                    role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                          <?= ($active_menu ?? '') === 'akun' ? 'bg-yellow-400 text-black font-semibold shadow-md' : 'text-gray-700 hover:bg-yellow-100 hover:text-black' ?>">
                    <i class="fa-solid fa-user-gear w-5 text-center text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm md:text-base">Akun</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= site_url('logout') ?>"
                    role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-gray-700 hover:bg-red-500 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm md:text-base">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>