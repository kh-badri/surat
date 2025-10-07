<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Surat Masuk Keluar</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Menggunakan font Merriweather untuk judul, Inter untuk teks lainnya */
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-serif-merriweather {
            font-family: 'Merriweather', serif;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="flex w-full max-w-5xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl">

            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                <div class="w-full max-w-md mx-auto">
                    <div class="flex flex-col items-center justify-center mb-8">
                        <img src="<?= base_url('public/una.png') ?>" alt="Logo UNA" class="h-16 w-auto mb-4">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-serif-merriweather text-gray-900">Masuk ke Akun Anda</h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-2">Masuk untuk mengelola surat masuk dan keluar.</p>
                    </div>

                    <?php $errorMessage = session()->getFlashdata('error'); ?>
                    <?php if ($errorMessage) : ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal',
                                text: '<?= esc($errorMessage, 'js') ?>',
                            });
                        </script>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="post" class="space-y-6">
                        <?= csrf_field() ?>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1">
                                <input id="username" name="username" type="text" required value="<?= old('username') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Masukkan username Anda">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Login Sebagai</label>
                            <div class="mt-1">
                                <select id="role" name="role" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out">
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="Prodi" <?php if (old('role') == 'Prodi') echo 'selected'; ?>>Prodi</option>
                                    <option value="Fakultas" <?php if (old('role') == 'Fakultas') echo 'selected'; ?>>Fakultas</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="<?= site_url('register') ?>" class="font-medium text-yellow-600 hover:text-yellow-500">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8 bg-yellow-50 relative">
                <img src="<?= base_url('public/surat2.png') ?>" alt="Ilustrasi Surat" class="object-contain w-full h-full rounded-2xl">
                <div class="absolute inset-0 rounded-2xl"></div>
                <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/80 backdrop-blur-sm rounded-lg">
                    <h3 class="text-xl font-bold font-serif-merriweather text-gray-900">Manajemen Surat yang Efisien</h3>
                    <p class="mt-2 text-sm text-gray-700">Masuk sekarang untuk mengelola surat masuk dan surat keluar Anda dengan lebih rapi dan terorganisir.</p>
                </div>
            </div>

        </div>
    </div>

</body>

</html>

<?php $successMessage = session()->getFlashdata('success'); ?>
<?php if ($successMessage): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= esc($successMessage, 'js') ?>',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "<?= site_url('login') ?>";
        });
    </script>
<?php endif; ?>