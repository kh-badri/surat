<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Header Halaman dengan Ikon -->
    <header class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
            <i class="fa-solid fa-user-circle text-yellow-500"></i>
            <span>Akun Saya</span>
        </h1>
        <p class="mt-1 text-gray-500">Kelola informasi profil dan keamanan akun Anda di sini.</p>
    </header>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Informasi Profil -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-200 h-full">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-3 mb-6">
                    <i class="fa-solid fa-address-card text-yellow-500"></i>
                    Informasi Profil
                </h2>
                <form action="<?= site_url('akun/update_profil') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Bagian Upload Foto -->
                    <div class="flex flex-col sm:flex-row items-center sm:space-x-6 mb-8 pb-8 border-b border-gray-200">
                        <img class="h-24 w-24 rounded-full object-cover mb-4 sm:mb-0 ring-4 ring-offset-2 ring-yellow-400"
                            src="<?= base_url('/uploads/foto_profil/' . esc($user['foto'])) . '?t=' . time() ?>"
                            alt="Foto Profil">
                        <div>
                            <label for="foto" class="cursor-pointer inline-flex items-center gap-2 bg-yellow-100 text-yellow-800 font-semibold px-4 py-2 rounded-lg transition-colors hover:bg-yellow-200">
                                <i class="fa-solid fa-camera"></i>
                                <span>Ganti Foto</span>
                            </label>
                            <input type="file" name="foto" id="foto" class="hidden">
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG (Maksimal 1MB)</p>
                        </div>
                    </div>

                    <!-- Input Fields -->
                    <div class="space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" value="<?= esc($user['username']) ?>"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed text-gray-600" disabled>
                        </div>
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-6 bg-yellow-500 text-black font-bold px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:bg-yellow-600">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Ganti Password -->
        <div>
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-200 h-full">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-3 mb-6">
                    <i class="fa-solid fa-key text-yellow-500"></i>
                    Ganti Password
                </h2>
                <form action="<?= site_url('akun/update_sandi') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        <div>
                            <label for="password_lama" class="block text-sm font-medium text-gray-700">Password Lama</label>
                            <input type="password" name="password_lama" id="password_lama"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" required>
                        </div>
                        <div>
                            <label for="password_baru" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="password_baru" id="password_baru"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" required>
                        </div>
                        <div>
                            <label for="konfirmasi_password" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" required>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full mt-6 bg-gray-800 text-white font-bold px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:bg-black">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= esc(session()->getFlashdata('success'), 'js') ?>',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul><?php foreach (session()->getFlashdata('errors') as $error) : ?><li class="text-left"><?= esc($error, 'js') ?></li><?php endforeach ?></ul>',
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection(); ?>