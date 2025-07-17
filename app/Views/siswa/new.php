<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8">

    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg max-w-2xl mx-auto">

        <div class="pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800"><?= esc($title); ?></h2>
            <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah ini untuk menambahkan data siswa baru.</p>
        </div>

        <form action="<?= site_url('siswa') ?>" method="post" class="mt-8 space-y-6">
            <?= csrf_field() ?>

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-calendar-days text-gray-400"></i>
                    </span>
                    <select name="tahun" id="tahun" class="pl-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out <?= ($validation->hasError('tahun')) ? 'border-red-500' : ''; ?>">
                        <option value="">-- Pilih Tahun --</option>
                        <?php
                        $tahunSekarang = date('Y');
                        for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 3; $tahun--) :
                        ?>
                            <option value="<?= $tahun ?>" <?= old('tahun') == $tahun ? 'selected' : '' ?>><?= $tahun ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <?php if ($validation->hasError('tahun')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('tahun') ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Kecamatan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-map-location-dot text-gray-400"></i>
                    </span>
                    <select name="kecamatan_id" id="kecamatan_id" class="pl-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out <?= ($validation->hasError('kecamatan_id')) ? 'border-red-500' : ''; ?>">
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php foreach ($wilayah_list as $w) : ?>
                            <option value="<?= $w['id'] ?>" <?= old('kecamatan_id') == $w['id'] ? 'selected' : '' ?>><?= esc($w['kecamatan']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if ($validation->hasError('kecamatan_id')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('kecamatan_id') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Siswa</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-users text-gray-400"></i>
                    </span>
                    <input type="number" name="jumlah" id="jumlah" value="<?= old('jumlah') ?>" placeholder="e.g., 150" class="pl-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out <?= ($validation->hasError('jumlah')) ? 'border-red-500' : ''; ?>">
                </div>
                <?php if ($validation->hasError('jumlah')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('jumlah') ?></p>
                <?php endif; ?>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <p class="text-sm font-medium text-gray-700">Hasil Perhitungan (Otomatis)</p>
                <p class="text-xs text-gray-500 mb-4">Kolom ini akan terisi setelah data disimpan dan dihitung.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600">Probabilitas</label>
                        <input type="text" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm py-2 px-3 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600">CDF</label>
                        <input type="text" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm py-2 px-3 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600">Batas</label>
                        <input type="text" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm py-2 px-3 cursor-not-allowed" readonly>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 mt-6">
                <a href="<?= base_url('/siswa') ?>" class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fa-solid fa-save mr-2"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>