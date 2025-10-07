<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Surat Masuk Keluar</title>

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

        /* Style untuk pesan error validasi */
        .alert-error {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #b91c1c;
        }

        .alert-error ul {
            list-style-position: inside;
            padding-left: 0;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="flex w-full max-w-5xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl">

            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                <div class="w-full max-w-md mx-auto">
                    <div class="mb-8 text-left">
                        <h1 class="text-3xl font-bold font-serif-merriweather text-gray-900">Buat Akun Anda</h1>
                        <p class="text-sm text-gray-500">Silakan lengkapi data untuk mengakses sistem surat menyurat.</p>
                    </div>

                    <?php
                    $validation = \Config\Services::validation();
                    if ($validation->getErrors()):
                    ?>
                        <div class="alert-error border px-4 py-3 rounded-lg relative mb-6" role="alert">
                            <strong class="font-bold">Terjadi Kesalahan!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                <?php foreach ($validation->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('register') ?>" method="post" class="space-y-6">
                        <?= csrf_field() ?>

                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="mt-1">
                                <input id="nama_lengkap" name="nama_lengkap" type="text" required value="<?= old('nama_lengkap') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Nama lengkap Anda">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" required value="<?= old('email') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Masukkan alamat email valid">
                            </div>
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1">
                                <input id="username" name="username" type="text" required value="<?= old('username') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Pilih username unik">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Minimal 8 karakter">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <div class="mt-1">
                                <input id="password_confirm" name="password_confirm" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"
                                    placeholder="Ulangi password Anda">
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
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
                                Daftar
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="<?= site_url('login') ?>" class="font-medium text-yellow-600 hover:text-yellow-500">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8 bg-yellow-50 relative">
                <img src="<?= base_url('public/surat.png') ?>" alt="Ilustrasi Surat" class="object-contain w-full h-full rounded-2xl">
                <div class="absolute inset-0 rounded-2xl"></div>
                <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/80 backdrop-blur-sm rounded-lg">
                    <h3 class="text-xl font-bold font-serif-merriweather text-gray-900">Manajemen Surat yang Efisien</h3>
                    <p class="mt-2 text-sm text-gray-700">Daftar sekarang untuk mengelola surat masuk dan surat keluar Anda dengan lebih rapi dan terorganisir.</p>
                </div>
            </div>

        </div>
    </div>

</body>

</html>