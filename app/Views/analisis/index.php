<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header Halaman -->
    <div class="text-center md:text-left mb-8">
        <h1 class="text-3xl font-bold text-stone-800">Analisis Pola Waktu Tidur</h1>
        <p class="text-gray-600 mt-1">Lakukan analisis deret waktu pada data tidur Anda.</p>
    </div>

    <!-- Konten Utama -->
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4 text-stone-700">Mulai Analisis</h2>

        <p class="text-gray-600 mb-6">Klik tombol di bawah untuk memulai analisis deret waktu pada data tidur yang tersedia.</p>

        <button id="startAnalysisBtn" class="w-full bg-amber-700 text-white font-bold py-3 px-4 rounded-lg hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition-transform transform hover:scale-105">
            Mulai Analisis Time Series
        </button>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden text-center mt-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-amber-700"></div>
            <p class="text-gray-600 mt-2">Sedang melakukan analisis, mohon tunggu...</p>
        </div>

        <!-- Area untuk menampilkan hasil analisis -->
        <div id="analysisResults" class="mt-12 hidden">
            <h2 class="text-xl font-semibold mb-4 text-stone-700">Hasil Analisis</h2>
            <div class="bg-stone-50 p-4 rounded-lg border border-stone-200">
                <h3 class="text-lg font-semibold text-stone-800 mb-2">Ringkasan Statistik</h3>
                <pre id="summaryOutput" class="whitespace-pre-wrap text-sm text-gray-700"></pre>
            </div>

            <div class="mt-8 bg-stone-50 p-4 rounded-lg border border-stone-200">
                <h3 class="text-lg font-semibold text-stone-800 mb-2">Visualisasi Deret Waktu</h3>
                <img id="analysisPlot" src="" alt="Time Series Plot" class="w-full h-auto max-w-full rounded-lg shadow-md mt-4" onerror="this.onerror=null;this.src='https://placehold.co/600x400/E5E7EB/374151?text=Plot+Tidak+Tersedia';">
            </div>

            <!-- Anda bisa menambahkan bagian lain untuk peramalan, dll. -->
            <div class="mt-8 bg-stone-50 p-4 rounded-lg border border-stone-200">
                <h3 class="text-lg font-semibold text-stone-800 mb-2">Peramalan</h3>
                <p id="forecastOutput" class="text-gray-700">Hasil peramalan akan muncul di sini.</p>
            </div>
        </div>

        <!-- Area untuk menampilkan pesan error -->
        <div id="errorDisplay" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg mt-8" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <p id="errorMessage" class="text-sm"></p>
        </div>

    </div>
</div>

<script>
    document.getElementById('startAnalysisBtn').addEventListener('click', async () => {
        const startAnalysisBtn = document.getElementById('startAnalysisBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const analysisResults = document.getElementById('analysisResults');
        const errorDisplay = document.getElementById('errorDisplay');
        const errorMessage = document.getElementById('errorMessage');

        // Sembunyikan hasil dan error sebelumnya
        analysisResults.classList.add('hidden');
        errorDisplay.classList.add('hidden');
        errorMessage.textContent = '';

        // Tampilkan loading indicator dan nonaktifkan tombol
        startAnalysisBtn.disabled = true;
        startAnalysisBtn.classList.add('opacity-50', 'cursor-not-allowed');
        loadingIndicator.classList.remove('hidden');

        try {
            // Lakukan permintaan AJAX ke controller CI4
            const response = await fetch('<?= site_url('analisis/perform') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Menandakan ini adalah AJAX request
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>' // Penting untuk keamanan CI4
                },
                body: JSON.stringify({}) // Kirim body kosong jika tidak ada data input
            });

            const result = await response.json();

            if (response.ok) {
                // Tampilkan hasil
                document.getElementById('summaryOutput').textContent = result.summary || 'Tidak ada ringkasan.';
                document.getElementById('forecastOutput').textContent = result.forecast || 'Tidak ada peramalan.';
                if (result.plot_base64) {
                    document.getElementById('analysisPlot').src = `data:image/png;base64,${result.plot_base64}`;
                } else {
                    document.getElementById('analysisPlot').src = 'https://placehold.co/600x400/E5E7EB/374151?text=Plot+Tidak+Tersedia';
                }
                analysisResults.classList.remove('hidden');
            } else {
                // Tampilkan pesan error dari server
                errorMessage.textContent = result.message || 'Terjadi kesalahan yang tidak diketahui.';
                errorDisplay.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error during analysis:', error);
            errorMessage.textContent = 'Gagal terhubung ke server atau terjadi kesalahan jaringan.';
            errorDisplay.classList.remove('hidden');
        } finally {
            // Sembunyikan loading indicator dan aktifkan kembali tombol
            loadingIndicator.classList.add('hidden');
            startAnalysisBtn.disabled = false;
            startAnalysisBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });
</script>

<?= $this->endSection(); ?>