<aside class="w-64 min-h-screen bg-white border-r hidden md:block">
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-4">Menu</h2>
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('/') ?>"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200
                          <?= ($active_menu ?? '') === 'dashboard'
                                ? 'bg-blue-100 text-blue-600 font-semibold'
                                : 'text-gray-600 hover:bg-gray-100' ?>">

                    <i class="fa-solid fa-house mr-3 w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('/akun') ?>"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200
                          <?= ($active_menu ?? '') === 'akun'
                                ? 'bg-blue-100 text-blue-600 font-semibold'
                                : 'text-gray-600 hover:bg-gray-100' ?>">

                    <i class="fa-solid fa-user mr-3 w-5 text-center"></i>
                    <span>Akun</span>
                </a>
            </li>
        </ul>
    </div>
</aside>