<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 w-full max-w-4xl overflow-hidden">
        <div class="flex flex-col lg:flex-row min-h-[500px]">

            <!-- Left Column - Form Login -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <div class="max-w-sm mx-auto w-full">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Selamat Datang</h1>
                        <p class="text-gray-600 text-sm">Login Untuk Masuk ke Sistem Prediksi Tenaga Pendidik</p>
                    </div>

                    <form action="<?= base_url('/login') ?>" method="post" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" name="username" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan username">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan password">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2.5 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium">
                            Masuk
                        </button>

                        <div class="text-center pt-3">
                            <p class="text-gray-600 text-sm">
                                Belum punya akun?
                                <a href="<?= site_url('register') ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Simple Illustration -->
            <div class="lg:w-1/2 bg-blue-50 p-8 lg:p-12 flex items-center justify-center">
                <div class="text-center">
                    <!-- Simple SVG Icon -->
                    <svg viewBox="0 0 200 200" class="w-32 h-32 mx-auto mb-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background Circle -->
                        <circle cx="100" cy="100" r="90" fill="#3B82F6" opacity="0.1" />

                        <!-- Teacher Icon -->
                        <g transform="translate(100, 100)">
                            <!-- Head -->
                            <circle cx="0" cy="-30" r="20" fill="#3B82F6" />

                            <!-- Body -->
                            <rect x="-15" y="-10" width="30" height="35" rx="5" fill="#3B82F6" />

                            <!-- Arms -->
                            <rect x="-25" y="-5" width="10" height="20" rx="5" fill="#3B82F6" />
                            <rect x="15" y="-5" width="10" height="20" rx="5" fill="#3B82F6" />

                            <!-- Legs -->
                            <rect x="-10" y="20" width="8" height="25" rx="4" fill="#3B82F6" />
                            <rect x="2" y="20" width="8" height="25" rx="4" fill="#3B82F6" />

                            <!-- Book in hand -->
                            <rect x="20" y="-8" width="12" height="8" rx="1" fill="#60A5FA" />
                        </g>

                        <!-- Floating Elements -->
                        <circle cx="60" cy="60" r="3" fill="#3B82F6" opacity="0.3" />
                        <circle cx="140" cy="70" r="2" fill="#3B82F6" opacity="0.3" />
                        <circle cx="50" cy="140" r="2" fill="#3B82F6" opacity="0.3" />
                        <circle cx="150" cy="130" r="3" fill="#3B82F6" opacity="0.3" />
                    </svg>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Monte Carlo</h3>
                        <p class="text-gray-600 text-sm leading-relaxed max-w-xs">
                            Sistem prediksi kebutuhan tenaga pendidik yang akurat dan efisien
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