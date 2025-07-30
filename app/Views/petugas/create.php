<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= $title ?>
        </h2>

        <form action="<?= base_url('petugas/store') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Input Nama Petugas -->
            <div class="mb-4">
                <label for="nama_petugas" class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas:</label>
                <input type="text" name="nama_petugas" id="nama_petugas" value="<?= old('nama_petugas') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                              <?= $validation->hasError('nama_petugas') ? 'border-red-500' : '' ?>" required placeholder="Masukkan nama lengkap petugas">
                <?php if ($validation->hasError('nama_petugas')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_petugas') ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Alamat Petugas -->
            <div class="mb-4">
                <label for="alamat_petugas" class="block text-gray-700 text-sm font-bold mb-2">Alamat Petugas:</label>
                <textarea name="alamat_petugas" id="alamat_petugas" rows="3"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('alamat_petugas') ? 'border-red-500' : '' ?>" placeholder="Alamat lengkap petugas"><?= old('alamat_petugas') ?></textarea>
                <?php if ($validation->hasError('alamat_petugas')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_petugas') ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Nomor HP -->
            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">Nomor HP:</label>
                <input type="text" name="no_hp" id="no_hp" value="<?= old('no_hp') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                              <?= $validation->hasError('no_hp') ? 'border-red-500' : '' ?>" required placeholder="Mis: 081234567890">
                <?php if ($validation->hasError('no_hp')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp') ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email (Opsional):</label>
                <input type="email" name="email" id="email" value="<?= old('email') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                              <?= $validation->hasError('email') ? 'border-red-500' : '' ?>" placeholder="email@contoh.com">
                <?php if ($validation->hasError('email')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('email') ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Role (Dropdown) -->
            <div class="mb-6">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                <select name="role" id="role"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               <?= $validation->hasError('role') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="teknisi" <?= old('role') == 'teknisi' ? 'selected' : '' ?>>Teknisi</option>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="supervisor" <?= old('role') == 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="noc" <?= old('role') == 'noc' ? 'selected' : '' ?>>Noc</option>
                </select>
                <?php if ($validation->hasError('role')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role') ?></p>
                <?php endif; ?>
            </div>


            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Simpan Petugas
                </button>
                <a href="<?= base_url('petugas') ?>" class="w-full sm:w-auto text-center inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800 py-3 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>