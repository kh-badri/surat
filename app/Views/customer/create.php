<?= $this->extend('layout/layout') ?> <?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= $title ?>
        </h2>

        <form action="<?= base_url('customer/store') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="id_customer" class="block text-gray-700 text-sm font-bold mb-2">ID Customer:</label>
                <input type="text" name="id_customer" id="id_customer" value="<?= old('id_customer') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('id_customer') ? 'border-red-500' : '' ?>" required placeholder="Mis: CUST001 / ISP001">
                <?php if ($validation->hasError('id_customer')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('id_customer') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="nama_customer" class="block text-gray-700 text-sm font-bold mb-2">Nama Customer:</label>
                <input type="text" name="nama_customer" id="nama_customer" value="<?= old('nama_customer') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('nama_customer') ? 'border-red-500' : '' ?>" required placeholder="Masukkan nama lengkap customer">
                <?php if ($validation->hasError('nama_customer')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_customer') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('alamat') ? 'border-red-500' : '' ?>" placeholder="Alamat lengkap customer"><?= old('alamat') ?></textarea>
                <?php if ($validation->hasError('alamat')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">Nomor HP:</label>
                <input type="text" name="no_hp" id="no_hp" value="<?= old('no_hp') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('no_hp') ? 'border-red-500' : '' ?>" required placeholder="Mis: 081234567890">
                <?php if ($validation->hasError('no_hp')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email (Opsional):</label>
                <input type="email" name="email" id="email" value="<?= old('email') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                 <?= $validation->hasError('email') ? 'border-red-500' : '' ?>" placeholder="email@contoh.com">
                <?php if ($validation->hasError('email')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('email') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Simpan Customer
                </button>
                <a href="<?= base_url('customer') ?>" class="w-full sm:w-auto text-center inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800 py-3 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>