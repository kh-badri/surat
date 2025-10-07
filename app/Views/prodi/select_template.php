<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Buat Surat Baru</h1>
        <p class="text-lg text-gray-500 mt-2">Pilih salah satu jenis surat yang ingin Anda buat dari template di bawah ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <a href="<?= site_url('prodi/create?template=pengantar_kp'); ?>" class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl border-b-4 border-transparent hover:border-amber-500 transition-all duration-300 ease-in-out transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="bg-amber-100 text-amber-600 rounded-full p-5 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-briefcase fa-3x"></i>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-gray-800">Pengantar KP</h2>
                    <p class="text-gray-600 mt-2">Ajukan permohonan Surat Pengantar untuk pelaksanaan Kerja Praktek.</p>
                    <div class="mt-4 text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Pilih Template <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="<?= site_url('prodi/create?template=sk_pembimbing_kp'); ?>" class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl border-b-4 border-transparent hover:border-amber-500 transition-all duration-300 ease-in-out transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="bg-amber-100 text-amber-600 rounded-full p-5 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-user-tie fa-3x"></i>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-gray-800">SK Pembimbing KP</h2>
                    <p class="text-gray-600 mt-2">Buat surat usulan SK untuk Dosen Pembimbing Kerja Praktek.</p>
                    <div class="mt-4 text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Pilih Template <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="<?= site_url('prodi/create?template=sk_pembimbing_skripsi'); ?>" class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl border-b-4 border-transparent hover:border-amber-500 transition-all duration-300 ease-in-out transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="bg-amber-100 text-amber-600 rounded-full p-5 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-graduation-cap fa-3x"></i>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-gray-800">SK Pembimbing Skripsi</h2>
                    <p class="text-gray-600 mt-2">Buat surat usulan SK untuk Dosen Pembimbing Skripsi mahasiswa.</p>
                    <div class="mt-4 text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Pilih Template <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="<?= site_url('prodi/create?template=usulan_sk_sempro'); ?>" class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl border-b-4 border-transparent hover:border-amber-500 transition-all duration-300 ease-in-out transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="bg-amber-100 text-amber-600 rounded-full p-5 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-file-signature fa-3x"></i>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-gray-800">Usulan SK Sempro</h2>
                    <p class="text-gray-600 mt-2">Buat surat usulan SK untuk Dosen Pembanding Seminar Proposal.</p>
                    <div class="mt-4 text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Pilih Template <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="<?= site_url('prodi/create?template=usulan_sk_sidang'); ?>" class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl border-b-4 border-transparent hover:border-amber-500 transition-all duration-300 ease-in-out transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="bg-amber-100 text-amber-600 rounded-full p-5 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-university fa-3x"></i>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-gray-800">Usulan SK Sidang</h2>
                    <p class="text-gray-600 mt-2">Buat surat usulan SK untuk Dosen Penguji Sidang Meja Hijau.</p>
                    <div class="mt-4 text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Pilih Template <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>

    </div>
</div>
<?= $this->endSection(); ?>