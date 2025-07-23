<aside class="w-64 min-h-screen bg-green border-r flex flex-col hidden md:block">

    <div class="flex items-center p-4">
        <img
            src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>"
            alt="Foto Profil"
            class="w-10 h-10 rounded object-cover border-2 border-blue-300 mr-4">
        <div class="ml-3">
            <p class="text-xl font-semibold text-gray-800"><?= esc(session()->get('username')) ?></p>
        </div>
    </div>
    <hr class="border-gray-200">

    <div class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('/') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'dashboard' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-house mr-3 w-5 text-center"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/dataset') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'dashboard' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-house mr-3 w-5 text-center"></i>
                    <span>Dataset</span>
                </a>
            </li>
    </div>

    <div class="mt-12 p-4">
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('/akun') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'akun' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-user-gear mr-3 w-5 text-center"></i>
                    <span>Akun</span>
                </a>
            </li>
        </ul>
    </div>

</aside>