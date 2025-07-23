<aside id="sidebar" class="bg-white w-64 min-h-screen flex flex-col fixed inset-y-0 left-0 z-30
                           transform -translate-x-full md:relative md:translate-x-0 
                           transition-transform duration-300 ease-in-out border-r border-gray-200">

    <div class="flex flex-col items-center p-4">
        <img
            src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>"
            alt="Foto Profil"
            class="w-18 h-18 rounded-full object-cover">

        <div class="mt-4 text-center">
            <p class="text-lg font-bold text-gray-800">
                Hallo, <?= esc(session()->get('username')) ?>
            </p>
        </div>
    </div>


    <div class="flex-grow p-4">
        <hr class="border-gray-200 ">
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'home' ? 'bg-amber-700 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-700 hover:text-white' ?>">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span class="font-medium">Home</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/dataset') ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'dataset' ? 'bg-amber-700 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-700 hover:text-white' ?>">
                    <i class="fa-solid fa-database w-5 text-center"></i>
                    <span class="font-medium">Dataset</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/analisis') ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'analisis' ? 'bg-amber-700 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-700 hover:text-white' ?>">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span class="font-medium">Analisis Pola Tidur</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="p-4 mt-auto">
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('/akun') ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                <?= ($active_menu ?? '') === 'akun' ? 'bg-amber-700 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-700 hover:text-white' ?>">
                    <i class="fa-solid fa-user-gear w-5 text-center"></i>
                    <span class="font-medium">Akun</span>
                </a>
            </li>
            <li>
                <a href="<?= site_url('logout') ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-black hover:bg-red-700 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>