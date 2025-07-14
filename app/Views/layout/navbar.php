<nav class="bg-blue-700 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-xl font-bold">Montecarlo App</div>
        <div>
            <a href="<?= base_url('akun') ?>" class="opacity-75 hover:opacity-100 transition-opacity duration-200 font-semibold">
                <i class="fa-solid fa-user"></i>
                <span class="mr-2"><?= esc(session()->get('username')) ?></span>
            </a>
            <a href="<?= base_url('/') ?>" class="mr-4 opacity-75 hover:opacity-100 transition-opacity duration-200 font-semibold">Dashboard</a>
            <a href="<?= site_url('logout') ?>" class="text-red-300 opacity-75 hover:opacity-100 transition-opacity duration-200 font-semibold">Logout</a>

        </div>
    </div>
</nav>