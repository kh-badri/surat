<nav class="bg-amber-700 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">

        <div class="flex items-center">
            <div class="text-xl font-bold">Pola Tidur App</div>
        </div>

        <div>
            <a href="<?= base_url('akun') ?>" class="opacity-75 hover:opacity-100 font-semibold inline-flex items-center transition-opacity duration-200">
                <i class="fa-solid fa-user mr-2"></i>
                <span></span>
            </a>
            <a href="<?= base_url('/') ?>" class="ml-4 mr-4 opacity-75 hover:opacity-100 font-semibold transition-opacity duration-200">Dashboard</a>
            <a href="<?= site_url('logout') ?>" class="opacity-75 hover:opacity-100 font-semibold transition-opacity duration-200">Logout</a>
        </div>

    </div>
</nav>