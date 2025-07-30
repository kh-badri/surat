<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pola Tidur App') ?></title>

    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Page Loader - Minimal custom CSS */
        #page-loader {
            position: fixed;
            inset: 0;
            background: white;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s, visibility 0.3s;
        }

        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 80px;
            height: 80px;
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Custom scrollbar untuk sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="spinner"></div>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 opacity-0 invisible transition-all duration-300 md:hidden"></div>

    <!-- Main Container -->
    <div class="grid grid-cols-[auto_1fr] min-h-screen transition-all duration-300" id="mainContainer">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-lg p-6 overflow-y-auto transition-all duration-300 custom-scrollbar
                              md:relative md:translate-x-0 md:h-full
                              fixed top-0 left-0 h-screen z-40 -translate-x-full
                              flex flex-col">
            <?= $this->include('layout/sidebar') ?>
        </aside>

        <main id="mainContent" class="bg-gray-100 p-6 overflow-x-hidden min-w-0 transition-all duration-300
                             col-start-1 md:col-start-2 col-span-full md:col-span-1">

            <div class="bg-white p-4 shadow-md rounded-lg mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <button id="sidebarToggle" class="inline-flex items-center justify-center p-3 rounded-lg bg-white shadow-sm hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-700 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-bars text-gray-600 text-xl"></i>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <img src="<?= base_url('public/inmeet-logo.png') ?>" alt="Logo Perusahaan" class="h-12 w-auto">
                        <span class="text-xl font-bold text-amber-600">Ticketing App</span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <?= $this->renderSection('content') ?>
            </div>

        </main>
    </div>

    <?= $this->include('layout/footer') ?>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden p-4">
        <div class="relative max-w-full max-h-full">
            <img id="modalImage" src="" alt="Foto Profil Penuh" class="max-w-full max-h-screen object-contain">
            <button id="closeModal" class="absolute top-4 right-4 text-white text-3xl font-bold bg-red-600 hover:bg-red-700 rounded-full w-10 h-10 flex items-center justify-center transition-colors duration-200">&times;</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Page Loader
        window.addEventListener('load', () => {
            document.getElementById('page-loader').classList.add('hidden');
        });

        // SweetAlert Notifications
        document.addEventListener('DOMContentLoaded', () => {
            <?php if ($success = session()->getFlashdata('success')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '<?= esc($success, 'js') ?>',
                    timer: 2500,
                    showConfirmButton: false
                });
            <?php endif; ?>
            <?php if ($error = session()->getFlashdata('error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= esc($error, 'js') ?>',
                    timer: 2500,
                    showConfirmButton: false
                });
            <?php endif; ?>
            <?php if ($errors = session()->getFlashdata('errors')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    html: '<?= esc(implode('<br>', is_array($errors) ? $errors : [$errors]), 'js') ?>',
                    showConfirmButton: true
                });
            <?php endif; ?>
        });

        // Responsive Sidebar Logic
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContainer = document.getElementById('mainContainer');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            let isSidebarCollapsed = false;
            const isMobile = () => window.innerWidth < 768;

            // Desktop: Collapse/Expand sidebar
            const toggleDesktopSidebar = () => {
                if (isSidebarCollapsed) {
                    // Expand sidebar
                    sidebar.classList.remove('w-0', 'p-0', 'overflow-hidden');
                    sidebar.classList.add('w-64', 'p-6', 'flex-col');
                    mainContainer.classList.remove('grid-cols-[0_1fr]');
                    mainContainer.classList.add('grid-cols-[auto_1fr]');
                    isSidebarCollapsed = false;
                } else {
                    // Collapse sidebar
                    sidebar.classList.remove('w-64', 'p-6', 'flex-col');
                    sidebar.classList.add('w-0', 'p-0', 'overflow-hidden');
                    mainContainer.classList.remove('grid-cols-[auto_1fr]');
                    mainContainer.classList.add('grid-cols-[0_1fr]');
                    isSidebarCollapsed = true;
                }
            };

            // Mobile: Show/Hide sidebar overlay
            const toggleMobileSidebar = () => {
                const isVisible = sidebar.classList.contains('translate-x-0');
                if (isVisible) {
                    // Hide sidebar
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.remove('opacity-100', 'visible');
                    sidebarOverlay.classList.add('opacity-0', 'invisible');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    // Show sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    sidebarOverlay.classList.remove('opacity-0', 'invisible');
                    sidebarOverlay.classList.add('opacity-100', 'visible');
                    document.body.classList.add('overflow-hidden');
                }
            };

            const closeMobileSidebar = () => {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.remove('opacity-100', 'visible');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                document.body.classList.remove('overflow-hidden');
            };

            // Main toggle handler
            sidebarToggle.addEventListener('click', () => {
                if (isMobile()) {
                    toggleMobileSidebar();
                } else {
                    toggleDesktopSidebar();
                }
            });

            // Mobile overlay click to close
            sidebarOverlay.addEventListener('click', closeMobileSidebar);

            // Handle window resize
            window.addEventListener('resize', () => {
                if (isMobile()) {
                    // Reset to mobile state
                    sidebar.classList.remove('w-0', 'p-0', 'overflow-hidden');
                    sidebar.classList.add('w-64', 'p-6', '-translate-x-full', 'flex-col');
                    mainContainer.classList.remove('grid-cols-[0_1fr]');
                    mainContainer.classList.add('grid-cols-[auto_1fr]');
                    closeMobileSidebar();
                    isSidebarCollapsed = false;
                } else {
                    // Reset to desktop state
                    sidebar.classList.remove('-translate-x-full', 'translate-x-0');
                    sidebar.classList.add('flex-col');
                    closeMobileSidebar();

                    // Maintain collapsed state if it was collapsed
                    if (isSidebarCollapsed) {
                        sidebar.classList.remove('w-64', 'p-6', 'flex-col');
                        sidebar.classList.add('w-0', 'p-0', 'overflow-hidden');
                        mainContainer.classList.add('grid-cols-[0_1fr]');
                    } else {
                        sidebar.classList.add('w-64', 'p-6');
                        mainContainer.classList.add('grid-cols-[auto_1fr]');
                    }
                }
            });

            // Close mobile sidebar when clicking sidebar links
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (isMobile()) closeMobileSidebar();
                });
            });

            // ESC key to close mobile sidebar
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isMobile() && sidebar.classList.contains('translate-x-0')) {
                    closeMobileSidebar();
                }
            });
        });

        // Profile Image Modal
        document.addEventListener('DOMContentLoaded', () => {
            const profileImage = document.getElementById('profileImage');
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const closeModal = document.getElementById('closeModal');

            if (profileImage) {
                profileImage.addEventListener('click', () => {
                    modalImage.src = profileImage.src;
                    imageModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            }

            const hideModal = () => {
                imageModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            closeModal?.addEventListener('click', hideModal);
            imageModal.addEventListener('click', (e) => {
                if (e.target === imageModal) hideModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !imageModal.classList.contains('hidden')) {
                    hideModal();
                }
            });
        });

        // Smooth scroll for internal links
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>