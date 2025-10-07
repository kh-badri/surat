<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800"><?= esc($template_title); ?></h1>
            <p class="text-gray-500 mt-1">Isi data-data penting di bawah ini untuk membuat surat.</p>
        </div>

        <?php if (session()->has('errors')) : ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                <ul class="mt-2">
                    <?php foreach (session('errors') as $error) : ?>
                        <li class="ml-4 list-disc"><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('prodi'); ?>" method="post" id="form-surat">
            <?= csrf_field(); ?>
            <input type="hidden" name="tipe_surat" value="<?= esc($template); ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-8">
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100" value="<?= old('nomor_surat', $nomor_surat_otomatis ?? ''); ?>" readonly>
                </div>
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="w-full px-3 py-2 border <?= $validation->hasError('tanggal_surat') ? 'border-red-500' : 'border-gray-300' ?> rounded-md shadow-sm" value="<?= old('tanggal_surat') ?: date('Y-m-d'); ?>" required>
                </div>
                <div class="md:col-span-2">
                    <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
                    <input type="text" name="perihal" id="perihal" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100" value="<?= esc($template_title); ?>" readonly>
                </div>
            </div>

            <div class="border-t pt-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Mahasiswa</h2>
                <div id="mahasiswa-container" class="space-y-6"></div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="button" id="tambah-mahasiswa" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
                </button>
                <button type="button" id="hapus-mahasiswa" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 hidden">
                    <i class="fas fa-trash mr-2"></i> Hapus Mahasiswa
                </button>
            </div>

            <div class="mt-10 flex justify-end space-x-4 border-t pt-6">
                <a href="<?= site_url('prodi'); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-300">Batal</a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // PERBAIKAN: Menambahkan field baru untuk data lama (repopulate)
    const oldData = {
        npm: <?= json_encode(old('npm') ?: []); ?>,
        nama_mahasiswa: <?= json_encode(old('nama_mahasiswa') ?: []); ?>,
        judul: <?= json_encode(old('judul') ?: []); ?>,
        dosen_pembimbing: <?= json_encode(old('dosen_pembimbing') ?: []); ?>,
        dosen_pembanding_1: <?= json_encode(old('dosen_pembanding_1') ?: []); ?>,
        dosen_pembanding_2: <?= json_encode(old('dosen_pembanding_2') ?: []); ?>,
        dosen_penguji_1: <?= json_encode(old('dosen_penguji_1') ?: []); ?>,
        dosen_penguji_2: <?= json_encode(old('dosen_penguji_2') ?: []); ?>
    };

    document.addEventListener('DOMContentLoaded', function() {
        const template = "<?= esc($template); ?>";
        const container = document.getElementById('mahasiswa-container');
        const addButton = document.getElementById('tambah-mahasiswa');
        const removeButton = document.getElementById('hapus-mahasiswa');
        let mahasiswaCount = 0;

        function createMahasiswaFields(data = {}) {
            mahasiswaCount++;
            const div = document.createElement('div');
            div.className = 'mahasiswa-item grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 border p-4 rounded-lg relative bg-gray-50';
            div.dataset.id = mahasiswaCount;

            let fields = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                <input type="text" name="npm[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.npm || ''}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.nama_mahasiswa || ''}" required>
            </div>`;

            // PERBAIKAN: Mengubah input menjadi 2 kolom
            switch (template) {
                case 'usulan_sk_sempro':
                    fields += `
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Skripsi</label>
                        <input type="text" name="judul[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.judul || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
                        <input type="text" name="dosen_pembimbing[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_pembimbing || ''}">
                    </div>
                    <div></div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembanding I</label>
                        <input type="text" name="dosen_pembanding_1[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_pembanding_1 || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembanding II</label>
                        <input type="text" name="dosen_pembanding_2[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_pembanding_2 || ''}">
                    </div>`;
                    break;
                case 'usulan_sk_sidang':
                    fields += `
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Skripsi</label>
                        <input type="text" name="judul[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.judul || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
                        <input type="text" name="dosen_pembimbing[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_pembimbing || ''}">
                    </div>
                    <div></div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Penguji I</label>
                        <input type="text" name="dosen_penguji_1[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_penguji_1 || ''}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Penguji II</label>
                        <input type="text" name="dosen_penguji_2[]" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="${data.dosen_penguji_2 || ''}">
                    </div>`;
                    break;
                    // ... (case lain tetap sama)
            }

            div.innerHTML = fields;
            container.appendChild(div);
            updateRemoveButtonVisibility();
        }

        // ... (fungsi remove dan update visibility tetap sama)

        // PERBAIKAN: Menambahkan field baru saat repopulate data
        if (oldData.npm && oldData.npm.length > 0) {
            oldData.npm.forEach((npm, index) => {
                const data = {
                    npm: npm,
                    nama_mahasiswa: oldData.nama_mahasiswa[index] || '',
                    judul: oldData.judul[index] || '',
                    dosen_pembimbing: oldData.dosen_pembimbing[index] || '',
                    dosen_pembanding_1: oldData.dosen_pembanding_1[index] || '',
                    dosen_pembanding_2: oldData.dosen_pembanding_2[index] || '',
                    dosen_penguji_1: oldData.dosen_penguji_1[index] || '',
                    dosen_penguji_2: oldData.dosen_penguji_2[index] || '',
                };
                createMahasiswaFields(data);
            });
        } else {
            createMahasiswaFields();
        }

        addButton.addEventListener('click', () => createMahasiswaFields({}));
        removeButton.addEventListener('click', removeLastMahasiswa);
    });
</script>
<?= $this->endSection(); ?>