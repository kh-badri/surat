<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
        <form action="<?= base_url('/login') ?>" method="post" class="space-y-4">
            <div>
                <label class="block text-sm">Username</label>
                <input type="text" name="username" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
            </div>
            <div class="text-center mt-4">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="<?= site_url('register') ?>" class="text-blue-600 hover:underline font-semibold">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
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