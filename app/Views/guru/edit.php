<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-4"><?= $title ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="<?= site_url('guru/update/' . $guru['id_guru']) ?>" method="post">
        <?= csrf_field() ?>

        <!-- Kecamatan -->
        <div class="mb-4">
            <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
            <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">-- Pilih Kecamatan --</option>
                <?php foreach ($wilayah as $w) : ?>
                    <option value="<?= $w['id'] ?>" <?= ($guru['kecamatan_id'] ?? old('kecamatan_id')) == $w['id'] ? 'selected' : '' ?>><?= $w['kecamatan'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($validation->hasError('kecamatan_id')) : ?>
                <p class="text-red-500 text-xs mt-1"><?= $validation->getError('kecamatan_id') ?></p>
            <?php endif; ?>
        </div>

        <!-- Tahun -->
        <div class="mb-4">
            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
            <input type="number" name="tahun" id="tahun" value="<?= $guru['tahun'] ?? old('tahun') ?>" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
            <?php if ($validation->hasError('tahun')) : ?>
                <p class="text-red-500 text-xs mt-1"><?= $validation->getError('tahun') ?></p>
            <?php endif; ?>
        </div>

        <!-- Jumlah -->
        <div class="mb-4">
            <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Guru</label>
            <input type="number" name="jumlah" id="jumlah" value="<?= $guru['jumlah'] ?? old('jumlah') ?>" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
            <?php if ($validation->hasError('jumlah')) : ?>
                <p class="text-red-500 text-xs mt-1"><?= $validation->getError('jumlah') ?></p>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>