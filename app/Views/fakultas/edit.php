<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto">
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
        <!-- Header Form -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Surat: <?= esc($surat['perihal']); ?></h1>
            <p class="text-gray-500">Perbarui data-data penting di bawah ini.</p>
        </div>

        <form action="<?= site_url('surat-keluar/update/' . $surat['id']); ?>" method="post" id="form-surat">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT"> <!-- Method spoofing for UPDATE -->
            <input type="hidden" name="tipe_surat" value="<?= esc($surat['tipe_surat']); ?>">

            <!-- Bagian Info Utama Surat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b pb-6">
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="<?= old('nomor_surat', $surat['nomor_surat']); ?>" required>
                </div>
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="<?= old('tanggal_surat', $surat['tanggal_surat']); ?>" required>
                </div>
                <div>
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                    <input type="text" name="lampiran" id="lampiran" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="<?= old('lampiran', $surat['lampiran']); ?>">
                </div>
                <div>
                    <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
                    <input type="text" name="perihal" id="perihal" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100" value="<?= esc($surat['perihal']); ?>" readonly>
                </div>
            </div>

            <!-- Bagian Detail Mahasiswa (Dinamis) -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Mahasiswa</h2>
            <div id="mahasiswa-container" class="space-y-4">
                <!-- Konten dinamis akan ditambahkan di sini oleh JavaScript -->
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="button" id="tambah-mahasiswa" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
                <button type="button" id="hapus-mahasiswa" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 hidden">
                    <i class="fas fa-trash"></i> Hapus Mahasiswa
                </button>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?= site_url('surat-keluar'); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-secondary font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Data mahasiswa dari controller
    const initialMahasiswaData = <?= $surat['detail_surat'] ?: '[]'; ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const template = "<?= esc($surat['tipe_surat']); ?>";
        const container = document.getElementById('mahasiswa-container');
        const addButton = document.getElementById('tambah-mahasiswa');
        const removeButton = document.getElementById('hapus-mahasiswa');
        let mahasiswaCount = 0;

        // Fungsi untuk membuat satu blok field mahasiswa
        function createMahasiswaFields(data = {}) {
            mahasiswaCount++;
            const div = document.createElement('div');
            div.className = 'mahasiswa-item grid grid-cols-1 md:grid-cols-2 gap-4 border p-4 rounded-lg relative';
            div.dataset.id = mahasiswaCount;

            let fields = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                <input type="text" name="mahasiswa[npm][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.npm || ''}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                <input type="text" name="mahasiswa[nama][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.nama || ''}" required>
            </div>
        `;

            switch (template) {
                case 'sk_pembimbing_kp':
                    fields += `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" name="mahasiswa[perusahaan][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.perusahaan || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Laporan KP</label>
                        <input type="text" name="mahasiswa[judul][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.judul || ''}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
                        <input type="text" name="mahasiswa[pembimbing][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.pembimbing || ''}">
                    </div>`;
                    break;
                case 'pengantar_kp':
                    fields += `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" name="mahasiswa[perusahaan][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.perusahaan || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                        <input type="text" name="mahasiswa[alamat_perusahaan][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.alamat_perusahaan || ''}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Pelaksanaan KP</label>
                        <input type="text" name="mahasiswa[waktu_pelaksanaan][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.waktu_pelaksanaan || ''}">
                    </div>`;
                    break;
                case 'sk_pembimbing_skripsi':
                    fields += `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Skripsi</label>
                        <input type="text" name="mahasiswa[judul][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.judul || ''}">
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
                        <input type="text" name="mahasiswa[pembimbing][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.pembimbing || ''}">
                    </div>`;
                    break;
            }

            div.innerHTML = fields;
            container.appendChild(div);
            updateRemoveButtonVisibility();
        }

        function removeLastMahasiswa() {
            if (mahasiswaCount > 1) {
                const lastItem = container.querySelector(`.mahasiswa-item[data-id='${mahasiswaCount}']`);
                if (lastItem) {
                    container.removeChild(lastItem);
                    mahasiswaCount--;
                }
            }
            updateRemoveButtonVisibility();
        }

        function updateRemoveButtonVisibility() {
            removeButton.classList.toggle('hidden', mahasiswaCount <= 1);
        }

        // Inisialisasi form dengan data yang ada
        if (initialMahasiswaData.length > 0) {
            initialMahasiswaData.forEach(data => createMahasiswaFields(data));
        } else {
            createMahasiswaFields(); // Jika tidak ada data, buat satu set field kosong
        }

        addButton.addEventListener('click', () => createMahasiswaFields());
        removeButton.addEventListener('click', removeLastMahasiswa);
    });
</script>
<?= $this->endSection(); ?>