<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<!-- Tambahkan style untuk animasi fade-in -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .fade-in-delay-1 {
        animation-delay: 0.1s;
    }

    .fade-in-delay-2 {
        animation-delay: 0.2s;
    }

    .fade-in-delay-3 {
        animation-delay: 0.3s;
    }

    .fade-in-delay-4 {
        animation-delay: 0.4s;
    }
</style>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">

    <!-- Header Halaman -->
    <header class="mb-8 fade-in">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Selamat Datang Kembali, <?= esc(session()->get('username')) ?>!</h1>
        <p class="mt-1 text-gray-500">Berikut adalah ringkasan aktivitas sistem persuratan Anda.</p>
    </header>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Kartu 1: Surat Keluar -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-yellow-300 fade-in fade-in-delay-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Surat Keluar</p>
                    <p class="text-3xl font-bold text-yellow-900">
                        <!-- Ganti dengan data dinamis: count($surat_keluar) -->
                        15
                    </p>
                </div>
                <div class="bg-yellow-400 p-3 rounded-full">
                    <i class="fa-solid fa-paper-plane text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Surat Masuk -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-blue-300 fade-in fade-in-delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Surat Masuk</p>
                    <p class="text-3xl font-bold text-blue-900">
                        <!-- Ganti dengan data dinamis -->
                        8
                    </p>
                </div>
                <div class="bg-blue-400 p-3 rounded-full">
                    <i class="fa-solid fa-inbox text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Menunggu Persetujuan -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-orange-300 fade-in fade-in-delay-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-orange-900">
                        <!-- Ganti dengan data dinamis -->
                        3
                    </p>
                </div>
                <div class="bg-orange-400 p-3 rounded-full">
                    <i class="fa-solid fa-clock-rotate-left text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kartu 4: Pengguna Aktif -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-green-300 fade-in fade-in-delay-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pengguna Aktif</p>
                    <p class="text-3xl font-bold text-green-900">
                        <!-- Ganti dengan data dinamis -->
                        1
                    </p>
                </div>
                <div class="bg-green-400 p-3 rounded-full">
                    <i class="fa-solid fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terkini & Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Aktivitas Terkini -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-gray-200 fade-in fade-in-delay-3">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Surat Keluar Terkini</h2>
            <div class="space-y-4">
                <!-- Contoh Item Aktivitas 1 -->
                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <i class="fa-solid fa-file-export"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Usulan SK Pembimbing Skripsi</p>
                        <p class="text-sm text-gray-500">Nomor: 002.1/097/PTI/FT-UNA/2025 - <span class="font-medium">2 hari yang lalu</span></p>
                    </div>
                    <a href="#" class="ml-auto text-yellow-600 hover:underline text-sm font-semibold">Lihat</a>
                </div>
                <!-- Contoh Item Aktivitas 2 -->
                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <i class="fa-solid fa-file-export"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Surat Pengantar Kerja Praktek</p>
                        <p class="text-sm text-gray-500">Nomor: 002.1/108/PTI/FT-UNA/2025 - <span class="font-medium">5 hari yang lalu</span></p>
                    </div>
                    <a href="#" class="ml-auto text-yellow-600 hover:underline text-sm font-semibold">Lihat</a>
                </div>
                <!-- Contoh Item Aktivitas 3 -->
                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <i class="fa-solid fa-file-export"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Usulan SK Pembimbing KP</p>
                        <p class="text-sm text-gray-500">Nomor: 002.1/062/PTI/FT-UNA/2025 - <span class="font-medium">1 minggu yang lalu</span></p>
                    </div>
                    <a href="#" class="ml-auto text-yellow-600 hover:underline text-sm font-semibold">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi Cepat -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 fade-in fade-in-delay-4">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="<?= site_url('surat-keluar/new') ?>" class="w-full flex items-center gap-3 text-left p-4 bg-yellow-400 text-black font-bold rounded-lg shadow transform transition-transform duration-200 hover:scale-105 hover:bg-yellow-500">
                    <i class="fa-solid fa-plus-circle text-xl"></i>
                    <span>Buat Surat Keluar</span>
                </a>
                <button disabled class="w-full flex items-center gap-3 text-left p-4 bg-gray-200 text-gray-500 font-bold rounded-lg cursor-not-allowed">
                    <i class="fa-solid fa-plus-circle text-xl"></i>
                    <span>Buat Surat Masuk</span>
                </button>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>