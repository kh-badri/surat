<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header Halaman -->
    <div class="text-center md:text-left mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Dataset</h1>
        <p class="text-gray-500 mt-1">Upload dan kelola dataset pola tidur Anda di sini.</p>
    </div>

    <!-- Konten Utama -->
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">

        <h2 class="text-xl font-semibold mb-4 text-gray-700">Import Dataset Baru</h2>

        <!-- Menampilkan Pesan Sukses atau Error -->
        <?php if (session()->getFlashdata('success')): ?>
            <div id="alert-success" class="alert bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Berhasil</p>
                <div class="prose prose-sm max-w-none"><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div id="alert-error" class="alert bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Gagal</p>
                <div class="prose prose-sm max-w-none"><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- Form Upload -->
        <form action="<?= url_to('DatasetController::upload') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">

                <!-- IKON YANG DIPERBAIKI -->
                <svg class="mx-auto h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l-3.75 3.75M12 9.75l3.75 3.75M3 17.25V21h18v-3.75m-18 0V12a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 12v5.25" />
                </svg>
                <!-- / IKON YANG DIPERBAIKI -->

                <label for="file-upload" class="mt-2 relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <span>Pilih sebuah file</span>
                    <input id="file-upload" name="dataset_csv" type="file" class="sr-only" accept=".csv" required>
                </label>
                <p class="text-xs text-gray-500 mt-1">Hanya file .CSV, maksimal 2MB</p>
                <p id="file-name" class="text-sm text-gray-600 mt-2 font-medium"></p>
            </div>
            <div class="mt-4 text-sm text-gray-500 bg-gray-50 p-3 rounded-md">
                <p><strong>Format Wajib:</strong> Pastikan file CSV memiliki kolom header: <code>tanggal</code>, <code>durasi_tidur</code>, <code>kualitas_tidur</code>.</p>
            </div>
            <div class="mt-8">
                <button type="submit" class="w-full bg-amber-700 text-white font-bold py-3 px-4 rounded-lg hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                    Upload dan Proses
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Data Tidur -->
<div class="mt-12">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Data Tidur Tersimpan</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Durasi Tidur (jam)</th>
                    <th class="px-4 py-2 text-left">Kualitas Tidur (1-10)</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php $no = 1;
                foreach ($data_tidur as $row): ?>
                    <tr>
                        <td class="px-4 py-2"><?= $no++ ?></td>
                        <td class="px-4 py-2"><?= esc($row->tanggal) ?></td>
                        <td class="px-4 py-2"><?= esc($row->durasi_tidur) ?></td>
                        <td class="px-4 py-2"><?= esc($row->kualitas_tidur) ?></td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="<?= site_url('dataset/edit/' . $row->id) ?>" class="text-blue-600 hover:underline">Edit</a>
                            <form action="<?= site_url('dataset/delete/' . $row->id) ?>" method="post" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php if (count($data_tidur) === 0): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500 italic">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Script untuk menampilkan nama file yang dipilih
    const fileInput = document.getElementById('file-upload');
    const fileNameDisplay = document.getElementById('file-name');
    if (fileInput) {
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = `File dipilih: ${fileInput.files[0].name}`;
            } else {
                fileNameDisplay.textContent = '';
            }
        });
    }

    // Script untuk menghilangkan notifikasi setelah beberapa detik
    setTimeout(() => {
        const alertSuccess = document.getElementById('alert-success');
        const alertError = document.getElementById('alert-error');
        if (alertSuccess) alertSuccess.style.display = 'none';
        if (alertError) alertError.style.display = 'none';
    }, 10000); // Notifikasi hilang setelah 10 detik
</script>

<?= $this->endSection(); ?>