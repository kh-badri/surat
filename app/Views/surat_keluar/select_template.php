<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto">
    <!-- Header Halaman -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pilih Template Surat Keluar</h1>
        <p class="text-gray-500">Pilih jenis surat yang ingin Anda buat.</p>
    </div>

    <!-- Pilihan Template -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Template 1: SK Pembimbing KP -->
        <a href="<?= site_url('surat-keluar/create?template=sk_pembimbing_kp'); ?>" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:bg-primary-50 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="bg-primary-500 text-secondary rounded-full p-3">
                    <i class="fas fa-user-tie fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SK Pembimbing KP</h2>
                    <p class="text-gray-600">Usulan SK Dosen Pembimbing Kerja Praktek.</p>
                </div>
            </div>
        </a>

        <!-- Template 2: Pengantar KP -->
        <a href="<?= site_url('surat-keluar/create?template=pengantar_kp'); ?>" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:bg-primary-50 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="bg-primary-500 text-secondary rounded-full p-3">
                    <i class="fas fa-briefcase fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Pengantar KP</h2>
                    <p class="text-gray-600">Permohonan Surat Pengantar Kerja Praktek.</p>
                </div>
            </div>
        </a>

        <!-- Template 3: SK Pembimbing Skripsi -->
        <a href="<?= site_url('surat-keluar/create?template=sk_pembimbing_skripsi'); ?>" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:bg-primary-50 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="bg-primary-500 text-secondary rounded-full p-3">
                    <i class="fas fa-graduation-cap fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SK Pembimbing Skripsi</h2>
                    <p class="text-gray-600">Usulan SK Dosen Pembimbing Skripsi.</p>
                </div>
            </div>
        </a>

    </div>
</div>
<?= $this->endSection(); ?>