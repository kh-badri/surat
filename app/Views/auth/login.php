<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Pastikan file CSS Anda dimuat, termasuk output dari Tailwind CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <!-- SweetAlert2 untuk notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tailwind CSS CDN (untuk pengembangan, di produksi sebaiknya di-build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tidak ada lagi konfigurasi Tailwind JIT di sini karena kita menggunakan kelas bawaan -->
</head>

<!-- Mengubah warna latar belakang body menjadi coklat muda/krem -->

<body class="bg-stone-100 min-h-screen flex items-center justify-center p-4">

    <!-- Mengubah border card menjadi lebih lembut -->
    <div class="bg-white rounded-lg shadow-xl border border-stone-200 w-full max-w-4xl overflow-hidden">
        <div class="flex flex-col lg:flex-row min-h-[500px]">

            <!-- Left Column - Form Login -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <div class="max-w-sm mx-auto w-full">
                    <div class="text-center mb-8">
                        <!-- Mengubah warna teks judul menjadi coklat gelap -->
                        <h1 class="text-2xl font-semibold text-stone-800 mb-2">Selamat Datang</h1>
                        <!-- Mengubah warna teks deskripsi menjadi abu-abu gelap -->
                        <p class="text-gray-600 text-sm">Login Untuk Masuk ke Aplikasi Data Mining Pola Tidur</p>
                    </div>

                    <form action="<?= base_url('/login') ?>" method="post" class="space-y-5">
                        <div>
                            <!-- Mengubah warna label menjadi coklat gelap -->
                            <label class="block text-sm font-medium text-stone-700 mb-2">Username</label>
                            <input type="text" name="username" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"
                                placeholder="Masukkan username">
                        </div>

                        <div>
                            <!-- Mengubah warna label menjadi coklat gelap -->
                            <label class="block text-sm font-medium text-stone-700 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"
                                placeholder="Masukkan password">
                        </div>

                        <!-- Mengubah warna tombol login menjadi coklat dan hover-nya -->
                        <button type="submit"
                            class="w-full bg-amber-700 text-white py-2.5 rounded-md hover:bg-amber-800 transition-colors duration-200 font-medium">
                            Masuk
                        </button>

                        <div class="text-center pt-3">
                            <!-- Mengubah warna teks "Belum punya akun?" menjadi abu-abu gelap -->
                            <p class="text-gray-600 text-sm">
                                Belum punya akun?
                                <!-- Mengubah warna link daftar menjadi coklat dan hover-nya -->
                                <a href="<?= site_url('register') ?>" class="text-amber-700 hover:text-amber-800 font-medium">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Simple Illustration -->
            <!-- Mengubah warna latar belakang kolom kanan menjadi coklat muda/krem -->
            <div class="lg:w-1/2 bg-amber-100 p-8 lg:p-12 flex items-center justify-center rounded-r-lg">
                <div class="text-center">
                    <!-- Image for Sleep Icon -->
                    <img src="<?= base_url('public/tidur.png') ?>" alt="Ilustrasi Pola Tidur"
                        class="w-36 h-36 mx-auto mb-6 object-contain rounded-full">

                    <div>
                        <!-- Mengubah teks judul ilustrasi sesuai judul skripsi -->
                        <h3 class="text-lg font-semibold text-stone-800 mb-2">Aplikasi Data Mining</h3>
                        <!-- Mengubah teks deskripsi ilustrasi sesuai judul skripsi -->
                        <p class="text-gray-600 text-sm leading-relaxed max-w-xs mx-auto">
                            Analisis Pola Waktu Tidur Menggunakan Metode Time Series Analysis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // 1. Simpan flashdata ke dalam variabel
    $successMessage = session()->getFlashdata('success');
    ?>
    <?php if ($successMessage): // 2. Periksa variabel, bukan memanggil fungsi lagi
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                // 3. Gunakan variabel untuk menampilkan pesan
                text: '<?= esc($successMessage, 'js') ?>',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "<?= base_url('/dashboard') ?>";
            });
        </script>
    <?php endif; ?>



    <?php
    // Ambil pesan flashdata 'error'
    $errorMessage = session()->getFlashdata('error');
    ?>
    <?php if ($errorMessage) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?= esc($errorMessage, 'js') ?>',
                // Tidak menggunakan timer agar pengguna bisa membaca pesan error
                // Tidak ada redirect setelah error
            });
        </script>
    <?php endif; ?>

</body>

</html>