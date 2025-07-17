<aside class="w-64 min-h-screen bg-white border-r flex flex-col hidden md:block">

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
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/wilayah') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'wilayah' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-location-dot mr-3 w-5 text-center"></i>
                    <span>Data Wilayah</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/siswa') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'siswa' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-users mr-3 w-5 text-center"></i>
                    <span>Data Siswa</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/guru') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'guru' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fa-user-graduate mr-3 w-5 text-center"></i>
                    <span>Data Tenaga Pendidik</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/prediksi') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'prediksi' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fas fa-poll-h mr-3 w-5 text-center"></i>
                    <span>Prediksi Monte Carlo</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/selisih') ?>" class=" flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'selisih' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fas fa-plus-minus mr-3 w-5 text-center"></i>
                    <span>Data Selisih</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/bantuan') ?>" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 
                    <?= ($active_menu ?? '') === 'bantuan' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <i class="fa-solid fas fa-question-circle mr-3 w-5 text-center"></i>
                    <span>Bantuan</span>
                </a>
            </li>
        </ul>
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