<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ISP Ticketing System</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
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

<body class="bg-gray-100">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="flex w-full max-w-5xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl">

            <!-- Kolom Kiri: Form Registrasi -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                <div class="w-full max-w-md mx-auto">
                    <!-- Judul -->
                    <div class="mb-8 text-left">
                        <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h1>
                        <p class="text-sm text-gray-500">Lengkapi formulir di bawah untuk mendaftar.</p>
                    </div>

                    <!-- Notifikasi Error Validasi -->
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

                        <!-- Input Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1">
                                <input id="username" name="username" type="text" required value="<?= old('username') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-150 ease-in-out"
                                    placeholder="Pilih username unik">
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-150 ease-in-out"
                                    placeholder="Minimal 8 karakter">
                            </div>
                        </div>

                        <!-- Input Konfirmasi Password -->
                        <div>
                            <label for="password_confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <div class="mt-1">
                                <input id="password_confirm" name="password_confirm" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-150 ease-in-out"
                                    placeholder="Ulangi password Anda">
                            </div>
                        </div>

                        <!-- Tombol Daftar -->
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150 ease-in-out">
                                Daftar
                            </button>
                        </div>
                    </form>

                    <!-- Link Login -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="<?= site_url('login') ?>" class="font-medium text-amber-600 hover:text-amber-500">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Gambar Ilustrasi (Sama seperti halaman login untuk konsistensi) -->
            <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8 bg-amber-50 relative">
                <img src="https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?q=80&w=2070&auto=format&fit=crop"
                    alt="Ilustrasi Registrasi" class="object-cover w-full h-full rounded-2xl">
                <div class="absolute inset-0 bg-amber-600 opacity-30 rounded-2xl"></div>
                <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/80 backdrop-blur-sm rounded-lg">
                    <h3 class="text-xl font-bold text-gray-900">Dapatkan Akses Penuh</h3>
                    <p class="mt-2 text-sm text-gray-700">Dengan mendaftar, Anda dapat membuat dan melacak status tiket laporan dengan lebih mudah.</p>
                </div>
            </div>

        </div>
    </div>

</body>

</html>