<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="bg-white/80 backdrop-blur-sm border border-white/20 rounded-2xl p-6 mb-8">
    <h3 class="text-xl font-bold text-slate-800 mb-6">Dashboard</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="<?= site_url('siswa'); ?>" class="group p-4 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl border border-blue-200 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 block">
            <div class="flex flex-col items-center text-center">
                <div class="p-3 bg-blue-500 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M9 20v-2a3 3 0 00-5.356-1.857M9 20h5v-2a3 3 0 00-5.356-1.857M12 12a4 4 0 100-8 4 4 0 000 8zm-2 10h4"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-blue-700">Total Siswa Tahun ini</span>
                <span class="font-bold text-lg text-blue-700 hover:text-blue-800 transition-colors duration-200"><?= esc($total_siswa); ?></span>
            </div>
        </a>
        <a href="<?= site_url('guru'); ?>" class="group p-4 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl border border-purple-200 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/25 block">
            <div class="flex flex-col items-center text-center">
                <div class="p-3 bg-purple-500 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-1.657 0-3-.895-3-2s1.343-2 3-2 3 .895 3 2-1.343 2-3 2zM12 14v4m0 0a2 2 0 100 4 2 2 0 000-4zm-8-3l.872.654a1 1 0 001.376-.051C6.726 12.33 8.163 11 12 11c3.837 0 5.274 1.33 5.752 1.55a1 1 0 001.376.051l.872-.654M4 11V7a2 2 0 012-2h12a2 2 0 012 2v4"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-purple-700">Total Guru Tahun ini </span>
                <span class="font-bold text-lg text-purple-700 hover:text-purple-800 transition-colors duration-200"><?= esc($total_guru); ?></span>
            </div>
        </a>
        <a href="<?= site_url('selisih'); ?>" class="group p-4 bg-gradient-to-br from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 rounded-xl border border-red-200 transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25 block">
            <div class="flex flex-col items-center text-center">
                <div class="p-3 bg-red-500 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-red-700">Selisih Kekurangan</span>
                <span class="font-bold text-lg text-red-800 mt-1"><?= esc($countKekurangan); ?></span>
            </div>
        </a>
        <a href="<?= site_url('selisih'); ?>" class="group p-4 bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl border border-green-200 transition-all duration-300 hover:shadow-lg hover:shadow-green-500/25 block">
            <div class="flex flex-col items-center text-center">
                <div class="p-3 bg-green-500 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-700">Selisih Kelebihan</span>
                <span class="font-bold text-lg text-green-800 mt-1"><?= esc($countKelebihan); ?></span>
            </div>
        </a>
    </div>
</div>

---

<div class="bg-white/80 backdrop-blur-sm border border-white/20 rounded-2xl p-6">
    <h3 class="text-xl font-bold text-slate-800 mb-6">Jumlah Siswa & Guru per Kecamatan</h3>
    <div class="space-y-4">
        <?php if (!empty($chartData)) : ?>
            <?php foreach ($chartData as $data) : ?>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm font-semibold text-slate-800 mb-2"><?= esc($data['name']); ?></p>
                    <div class="flex items-center space-x-4">
                        <div class="w-1/2">
                            <span class="text-xs font-medium text-blue-600">Siswa: <?= esc($data['total_siswa']); ?></span>
                            <div class="w-full bg-blue-100 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: <?= min(100, ($data['total_siswa'] / 2000) * 100); ?>%;"></div>
                            </div>
                        </div>
                        <div class="w-1/2">
                            <span class="text-xs font-medium text-purple-600">Guru: <?= esc($data['total_guru']); ?></span>
                            <div class="w-full bg-purple-100 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: <?= min(100, ($data['total_guru'] / 100) * 100); ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center text-gray-500">Tidak ada data kecamatan tersedia.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>