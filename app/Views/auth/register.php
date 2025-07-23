<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Data Mining Pola Tidur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Mengubah warna latar belakang body menjadi coklat muda/krem -->

<body class="bg-stone-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <!-- Mengubah warna teks judul menjadi coklat gelap -->
        <h2 class="text-2xl font-bold text-center mb-6 text-stone-800">Buat Akun Baru</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php $validation = \Config\Services::validation(); ?>
        <?php if ($validation->getErrors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul>
                    <?php foreach ($validation->getErrors() as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <!-- Mengubah warna label menjadi coklat gelap -->
                <label for="username" class="block text-stone-700">Username</label>
                <input type="text" name="username" id="username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-amber-600" required>
            </div>
            <div class="mb-4">
                <!-- Mengubah warna label menjadi coklat gelap -->
                <label for="password" class="block text-stone-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-amber-600" required>
            </div>
            <div class="mb-6">
                <!-- Mengubah warna label menjadi coklat gelap -->
                <label for="password_confirm" class="block text-stone-700">Konfirmasi Password</label>
                <input type="password" name="password_confirm" id="password_confirm" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-amber-600" required>
            </div>
            <div class="flex items-center justify-between">
                <!-- Mengubah warna tombol register menjadi coklat dan hover-nya -->
                <button type="submit" class="w-full bg-amber-700 text-white px-4 py-2 rounded-md hover:bg-amber-800">Register</button>
            </div>
        </form>
        <div class="text-center mt-4">
            <!-- Mengubah warna teks "Sudah punya akun?" menjadi abu-abu gelap -->
            <p class="text-gray-600">
                Sudah punya akun?
                <!-- Mengubah warna link login menjadi coklat dan hover-nya -->
                <a href="<?= site_url('login') ?>" class="text-amber-700 hover:underline font-semibold">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
</body>

</html>