<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header Halaman -->
    <div class="text-center md:text-left mb-8">
        <h1 class="text-3xl font-bold text-stone-800">Edit Data Tidur</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi pola tidur untuk tanggal ini.</p>
    </div>

    <!-- Konten Utama - Form Edit -->
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">

        <h2 class="text-xl font-semibold mb-4 text-stone-700">Form Edit Data</h2>

        <!-- Menampilkan Pesan Error Validasi -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Gagal Memperbarui</p>
                <?php
                $errors = session()->getFlashdata('error');
                if (is_array($errors)): ?>
                    <ul class="list-disc list-inside mt-2">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php else: ?>
                    <p><?= esc($errors) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Form Edit Data -->
        <form action="<?= site_url('dataset/update/' . $data_tidur->id) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-stone-700 mb-2">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"
                    value="<?= esc($data_tidur->tanggal) ?>" required>
            </div>
            <div class="mb-4">
                <label for="durasi_tidur" class="block text-sm font-medium text-stone-700 mb-2">Durasi Tidur (jam)</label>
                <input type="number" step="0.1" name="durasi_tidur" id="durasi_tidur"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"
                    value="<?= esc($data_tidur->durasi_tidur) ?>" required>
            </div>
            <div class="mb-6">
                <label for="kualitas_tidur" class="block text-sm font-medium text-stone-700 mb-2">Kualitas Tidur (1-10)</label>
                <input type="number" step="0.1" name="kualitas_tidur" id="kualitas_tidur"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"
                    value="<?= esc($data_tidur->kualitas_tidur) ?>" min="1" max="10" required>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- px-10 diubah menjadi px-6 agar presisi dengan tombol "Simpan Perubahan" -->
                <a href="<?= site_url('dataset') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-amber-700 text-white font-bold hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition-transform transform hover:scale-105">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>