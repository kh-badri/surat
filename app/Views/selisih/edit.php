<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Selisih</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="<?= site_url('selisih/update/' . $selisih['id_selisih']); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= (session('errors.tahun')) ? 'border-red-500' : ''; ?>" required>
                    <option value="">Pilih Tahun</option>
                    <?php foreach ($years as $year) : ?>
                        <option value="<?= $year; ?>" <?= (old('tahun', $selisih['tahun']) == $year) ? 'selected' : ''; ?>><?= $year; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.tahun')) : ?>
                    <p class="text-red-500 text-xs italic mt-2"><?= session('errors.tahun'); ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="kecamatan_id" class="block text-gray-700 text-sm font-bold mb-2">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= (session('errors.kecamatan_id')) ? 'border-red-500' : ''; ?>" required>
                    <option value="">Pilih Kecamatan</option>
                    <?php foreach ($kecamatans as $kecamatan) : ?>
                        <option value="<?= $kecamatan['id_prediksi']; ?>" <?= (old('kecamatan_id', $selisih['kecamatan_id']) == $kecamatan['id_prediksi']) ? 'selected' : ''; ?>><?= $kecamatan['kecamatan']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.kecamatan_id')) : ?>
                    <p class="text-red-500 text-xs italic mt-2"><?= session('errors.kecamatan_id'); ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="hasil_prediksi_id" class="block text-gray-700 text-sm font-bold mb-2">Hasil Prediksi</label>
                <input type="number" step="0.01" name="hasil_prediksi_id" id="hasil_prediksi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:shadow-outline" readonly value="<?= old('hasil_prediksi_id', $selisih['hasil_prediksi_id']); ?>">
            </div>

            <div class="mb-4">
                <label for="jumlah_guru_id" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Guru</label>
                <select name="jumlah_guru_id" id="jumlah_guru_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= (session('errors.jumlah_guru_id')) ? 'border-red-500' : ''; ?>" required>
                    <option value="">Pilih Jumlah Guru</option>
                    <?php foreach ($jumlah_gurus as $guru) : ?>
                        <option value="<?= $guru['id_guru']; ?>" <?= (old('jumlah_guru_id', $selisih['jumlah_guru_id']) == $guru['id_guru']) ? 'selected' : ''; ?>><?= $guru['jumlah']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.jumlah_guru_id')) : ?>
                    <p class="text-red-500 text-xs italic mt-2"><?= session('errors.jumlah_guru_id'); ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="kebutuhan" class="block text-gray-700 text-sm font-bold mb-2">Kebutuhan</label>
                <input type="number" step="0.01" name="kebutuhan" id="kebutuhan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:shadow-outline" readonly value="<?= old('kebutuhan', $selisih['kebutuhan']); ?>">
            </div>

            <div class="mb-4">
                <label for="nilai_selisih" class="block text-gray-700 text-sm font-bold mb-2">Nilai Selisih</label>
                <input type="number" step="0.01" name="nilai_selisih" id="nilai_selisih" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:shadow-outline" readonly value="<?= old('nilai_selisih', $selisih['nilai_selisih']); ?>">
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:shadow-outline" readonly value="<?= old('keterangan', $selisih['keterangan']); ?>">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Update Data
                </button>
                <a href="<?= site_url('selisih') ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tahunSelect = document.getElementById('tahun');
        const kecamatanSelect = document.getElementById('kecamatan_id');
        const hasilPrediksiInput = document.getElementById('hasil_prediksi_id');
        const jumlahGuruSelect = document.getElementById('jumlah_guru_id');
        const kebutuhanInput = document.getElementById('kebutuhan');
        const nilaiSelisihInput = document.getElementById('nilai_selisih');
        const keteranganInput = document.getElementById('keterangan');

        function calculateSelisih() {
            const hasilPrediksi = parseFloat(hasilPrediksiInput.value) || 0;
            // Mengambil nilai jumlah guru dari teks opsi yang dipilih
            const jumlahGuru = parseFloat(jumlahGuruSelect.options[jumlahGuruSelect.selectedIndex].text) || 0;

            // 1. Hitung kebutuhan dan bulatkan dengan pembulatan standar (LOGIKA DIPERBAIKI)
            const kebutuhan = Math.round(hasilPrediksi / 20);

            // 2. Hitung nilai selisih
            const nilaiSelisih = kebutuhan - jumlahGuru;

            // 3. Tentukan keterangan sesuai logika baru (LOGIKA DIPERBAIKI)
            const keterangan = (nilaiSelisih > 0) ? 'kekurangan' : 'kelebihan';

            // 4. Tampilkan hasil pada input fields
            kebutuhanInput.value = kebutuhan;
            nilaiSelisihInput.value = nilaiSelisih;
            keteranganInput.value = keterangan;
        }

        async function fetchHasilPrediksi() {
            const tahun = tahunSelect.value;
            const kecamatanId = kecamatanSelect.value;

            if (tahun && kecamatanId) {
                // Menggunakan site_url() untuk URL AJAX
                const response = await fetch(`<?= site_url('selisih/get_hasil_prediksi') ?>?tahun=${tahun}&kecamatan_id=${kecamatanId}`);
                const data = await response.json();
                hasilPrediksiInput.value = data.hasil_prediksi;
            } else {
                hasilPrediksiInput.value = 0;
            }
            // Hitung ulang selisih setiap kali hasil prediksi diambil
            calculateSelisih();
        }

        // Event Listeners
        tahunSelect.addEventListener('change', fetchHasilPrediksi);
        kecamatanSelect.addEventListener('change', fetchHasilPrediksi);
        jumlahGuruSelect.addEventListener('change', calculateSelisih);

        // Lakukan kalkulasi awal saat halaman edit dimuat
        // untuk mengisi nilai berdasarkan data yang ada
        fetchHasilPrediksi();
    });
</script>
<?= $this->endSection(); ?>