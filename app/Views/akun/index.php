<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-amber-600 text-shadow-lg">Akun Saya</h1>

    <!-- Grid responsif: 1 kolom di mobile, 2 kolom di md (tablet/desktop), dengan jarak antar kolom -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Kolom Informasi Profil: 100% lebar di mobile, 2/3 lebar di md (tablet/desktop) -->
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Informasi Profil</h2>
                <form action="<?= site_url('akun/update_profil') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="flex flex-col sm:flex-row items-center sm:space-x-6 mb-6">
                        <!-- Gambar profil: Pastikan ukuran w-24 h-24 sudah ada di Tailwind Anda -->
                        <img class="h-24 w-24 rounded-full object-cover mb-4 sm:mb-0"
                            src="<?= base_url('/uploads/foto_profil/' . esc($user['foto'])) . '?t=' . time() ?>"
                            alt="Foto Profil">
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Ganti Foto</label>
                            <!-- Input file: Sesuaikan ukuran font dan padding agar responsif -->
                            <input type="file" name="foto" id="foto"
                                class="mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (MAX. 1MB)</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Username</label>
                        <input type="text" id="username" value="<?= esc($user['username']) ?>"
                            class="w-full px-4 py-2 mt-2 border rounded-md bg-gray-100 cursor-not-allowed text-gray-800" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-gray-800">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-gray-800">
                    </div>
                    <button type="submit"
                        class="w-full bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition duration-150 ease-in-out">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Ganti Password: 100% lebar di mobile, 1/3 lebar di md (tablet/desktop) -->
        <div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Ganti Password</h2>
                <form action="<?= site_url('akun/update_sandi') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="password_lama" class="block text-gray-700">Password Lama</label>
                        <input type="password" name="password_lama" id="password_lama"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-gray-800" required>
                    </div>
                    <div class="mb-4">
                        <label for="password_baru" class="block text-gray-700">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-gray-800" required>
                    </div>
                    <div class="mb-4">
                        <label for="konfirmasi_password" class="block text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-gray-800" required>
                    </div>
                    <button type="submit"
                        class="w-full bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition duration-150 ease-in-out">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert scripts (moved to layout.php for consistency, but kept here for self-containment) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Pastikan script ini hanya dieksekusi sekali di layout.php, atau jika ini satu-satunya tempat
    // SweetAlert dipanggil. Jika sudah ada di layout.php, hapus dari sini.
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= esc(session()->getFlashdata('success'), 'js') ?>',
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: '<ul><?php foreach (session()->getFlashdata('errors') as $error) : ?><li class="text-left"><?= esc($error, 'js') ?></li><?php endforeach ?></ul>',
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection(); ?>