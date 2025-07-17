<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-4"><?= esc($title) ?></h1>

<form action="<?= site_url('wilayah/update/' . $wilayah['id']) ?>" method="post" class="bg-white p-6 rounded shadow-md w-full max-w-lg">

    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-4">
        <label for="kecamatan" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
        <input type="text" name="kecamatan" id="kecamatan" value="<?= esc($wilayah['kecamatan']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div class="flex items-center justify-end space-x-4">
        <a href="<?= site_url('wilayah') ?>" class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300">Batal</a>
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Perbarui</button>
    </div>

</form>

<?= $this->endSection() ?>