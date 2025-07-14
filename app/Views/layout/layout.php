<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Montecarlo App') ?></title>

    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Overlay yang menutupi seluruh halaman */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            /* Latar belakang putih solid */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Transisi untuk efek fade-out saat menghilang */
            transition: opacity 0.3s, visibility 0.3s;
        }

        /* Kelas untuk menyembunyikan loader */
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        /* Styling untuk bulatan spinner */
        .spinner {
            border: 8px solid #f3f3f3;
            /* Warna dasar lingkaran */
            border-top: 8px solid #3b82f6;
            /* Warna biru untuk bagian yang berputar */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
            /* Terapkan animasi berputar */
        }

        /* Animasi berputar */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <div id="page-loader">
        <div class="spinner"></div>
    </div>
    <?= $this->include('layout/navbar') ?>

    <div class="flex">
        <?= $this->include('layout/sidebar') ?>

        <main class="flex-1 p-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <?= $this->include('layout/footer') ?>


    <script>
        window.addEventListener('load', function() {
            document.getElementById('page-loader').classList.add('hidden');
        });
    </script>

    <?php
    // Ambil pesan flashdata dari sesi
    $success = session()->getFlashdata('success');
    ?>
    <?php if ($success) : // Jika ada pesan 'success', cetak script SweetAlert 
    ?>
        <script>
            // Panggil SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Login Sukses',
                text: '<?= esc($success, 'js') ?>', // Tampilkan pesan dari PHP
                timer: 2500, // Notifikasi hilang setelah 2.5 detik
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>

</html>