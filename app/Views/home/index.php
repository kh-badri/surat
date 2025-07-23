<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<!-- Hero Section: Pengantar Aplikasi -->
<div class="relative bg-gradient-to-br from-amber-700 to-amber-500 rounded-2xl p-8 md:p-12 mb-12 shadow-xl text-center overflow-hidden">
    <!-- Background pattern/overlay (optional, for more depth) -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMjAwIDIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIxMDAiIGN5PSIxMDAiIHI9IjYwIiBmaWxsPSIjRkZENzAwIiBvcGFjaXR5PSIwLjEiLz48Y2lyY2xlIGN4PSI1MCIgY3k9IjE1MCIgcj0iNDAiIGZpbGw9IiNGRkQ3MDAiIG9wYWNpdHk9IjAuMSIvPjxjaXJjbGUgY3g9IjE1MCIgY3k9IjUwIiByPSIzMCIgZmlsbD0iI0ZGRDcwMCIgb3BhY2l0eT0iMC4xIi8+PC9zdmc+');"></div>

    <h1 class="text-3xl md:text-3xl font-bold font-extrabold text-amber-700 leading-tight mb-4 relative z-10">
        Jelajahi Dunia Tidur Anda dengan Analisis Data
    </h1>
    <p class="text-lg text-amber-100 max-w-3xl mx-auto relative z-10">
        Selamat datang di aplikasi yang dirancang untuk membantu Anda memahami pola waktu tidur melalui kekuatan Time Series Analysis.
        Dapatkan wawasan mendalam untuk meningkatkan kualitas hidup Anda.
    </p>
    <!-- Main Hero SVG - Moon and Stars -->
    <svg class="w-24 h-24 md:w-32 md:h-32 mx-auto mt-8 text-amber-200 relative z-10 animate-bounce-slow" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 3a9 9 0 009 9 9 9 0 00-9 9c-4.97 0-9-4.03-9-9s4.03-9 9-9zm0 2a7 7 0 00-7 7 7 7 0 007 7 7 7 0 007-7 7 7 0 00-7-7zM15.5 8.5a.5.5 0 11-1 0 .5.5 0 011 0zM8.5 15.5a.5.5 0 11-1 0 .5.5 0 011 0zM18 12a.5.5 0 11-1 0 .5.5 0 011 0zM6 12a.5.5 0 11-1 0 .5.5 0 011 0zM12 6a.5.5 0 11-1 0 .5.5 0 011 0zM12 18a.5.5 0 11-1 0 .5.5 0 011 0z" />
    </svg>
</div>

<!-- Bagian Edukasi: Pentingnya Tidur Berkualitas -->
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg mb-8 border border-stone-200 hover:shadow-xl transition-shadow duration-300">
    <h2 class="text-2xl md:text-3xl font-semibold mb-4 text-stone-700 flex items-center">
        <svg class="w-8 h-8 text-amber-700 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C7.03 2 3 6.03 3 11s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM12 6a1 1 0 011 1v4a1 1 0 01-2 0V7a1 1 0 011-1z" />
            <path d="M12 14a1 1 0 011 1v1a1 1 0 01-2 0v-1a1 1 0 011-1z" />
        </svg>
        Pentingnya Tidur Berkualitas
    </h2>
    <p class="text-gray-700 leading-relaxed mb-4">
        Tidur bukan sekadar istirahat, melainkan fondasi penting bagi kesehatan fisik dan mental kita.
        Tidur yang cukup dan berkualitas berperan krusial dalam memulihkan energi, menguatkan sistem imun,
        meningkatkan fungsi kognitif seperti memori dan konsentrasi, serta mengatur suasana hati.
        Kurang tidur kronis dapat berdampak negatif pada produktivitas, kesehatan jantung, metabolisme,
        dan bahkan meningkatkan risiko berbagai penyakit.
    </p>
    <p class="text-gray-700 leading-relaxed">
        Aplikasi ini dirancang untuk membantu Anda memahami pola tidur Anda sendiri,
        memberikan wawasan yang dapat membantu Anda mencapai kualitas tidur yang lebih baik.
    </p>
</div>

<!-- Bagian Edukasi: Memahami Pola Waktu Tidur Anda -->
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg mb-8 border border-stone-200 hover:shadow-xl transition-shadow duration-300">
    <h2 class="text-2xl md:text-3xl font-semibold mb-4 text-stone-700 flex items-center">
        <svg class="w-8 h-8 text-amber-700 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
        </svg>
        Memahami Pola Waktu Tidur Anda
    </h2>
    <p class="text-gray-700 leading-relaxed mb-4">
        Pola waktu tidur merujuk pada kebiasaan tidur Anda sehari-hari, termasuk durasi tidur,
        kualitas tidur (seberapa nyenyak tidur Anda), dan konsistensi jadwal tidur.
        Setiap orang memiliki pola tidur yang unik, dipengaruhi oleh berbagai faktor seperti gaya hidup,
        usia, lingkungan, dan kondisi kesehatan.
    </p>
    <p class="text-gray-700 leading-relaxed">
        Dengan melacak dan menganalisis data tidur Anda secara berkala, kita dapat mengidentifikasi
        tren, anomali, dan kebiasaan yang mungkin tidak Anda sadari. Informasi ini sangat berharga
        untuk membuat perubahan positif demi tidur yang lebih baik.
    </p>
</div>

<!-- Bagian Edukasi: Apa itu Time Series Analysis? -->
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg mb-8 border border-stone-200 hover:shadow-xl transition-shadow duration-300">
    <h2 class="text-2xl md:text-3xl font-semibold mb-4 text-stone-700 flex items-center">
        <svg class="w-8 h-8 text-amber-700 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 16H4V8h4v8zm6 0h-4V8h4v8zm6 0h-4V8h4v8z" />
        </svg>
        Apa itu Time Series Analysis?
    </h2>
    <p class="text-gray-700 leading-relaxed mb-4">
        Time Series Analysis (Analisis Deret Waktu) adalah metode statistik yang digunakan untuk
        menganalisis data yang dikumpulkan pada interval waktu yang berurutan. Tujuannya adalah
        untuk memahami pola, tren, dan komponen musiman dalam data tersebut, serta untuk
        membuat peramalan (prediksi) nilai di masa depan.
    </p>
    <p class="text-gray-700 leading-relaxed">
        Dalam deret waktu, data tidak bersifat independen; nilai saat ini seringkali
        dipengaruhi oleh nilai-nilai sebelumnya. Analisis deret waktu membantu kita
        mengungkap hubungan tersembunyi ini dan membuat prediksi yang lebih akurat.
    </p>
</div>

<!-- Bagian Edukasi: Time Series Analysis pada Pola Tidur -->
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-stone-200 hover:shadow-xl transition-shadow duration-300">
    <h2 class="text-2xl md:text-3xl font-semibold mb-4 text-stone-700 flex items-center">
        <svg class="w-8 h-8 text-amber-700 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v-6h-2v6zm0-8h2V7h-2v2z" />
        </svg>
        Time Series Analysis pada Pola Tidur
    </h2>
    <p class="text-gray-700 leading-relaxed mb-4">
        Dalam konteks pola waktu tidur, Time Series Analysis menjadi alat yang sangat ampuh.
        Dengan menerapkan metode ini pada data durasi dan kualitas tidur Anda dari waktu ke waktu,
        kami dapat:
    </p>
    <ul class="list-disc list-inside text-gray-700 leading-relaxed ml-4 mb-4">
        <li>Mengidentifikasi Tren Jangka Panjang: Apakah durasi tidur Anda cenderung menurun atau meningkat seiring waktu?</li>
        <li>Mendeteksi Pola Musiman/Periodik: Apakah ada hari-hari tertentu dalam seminggu atau bulan di mana kualitas tidur Anda secara konsisten lebih baik atau lebih buruk?</li>
        <li>Melakukan Peramalan: Memprediksi durasi atau kualitas tidur Anda di masa depan berdasarkan pola historis.</li>
        <li>Mengungkap Anomali: Menemukan kejadian tidur yang tidak biasa yang mungkin memerlukan perhatian.</li>
    </ul>
    <p class="text-gray-700 leading-relaxed">
        Dengan wawasan ini, Anda dapat mengambil langkah proaktif untuk meningkatkan kebiasaan tidur Anda
        dan pada akhirnya, meningkatkan kualitas hidup secara keseluruhan.
    </p>
    <div class="mt-8 text-center">
        <p class="text-lg font-semibold text-stone-800 mb-4">Siap untuk menganalisis pola tidur Anda?</p>
        <a href="<?= site_url('dataset') ?>" class="inline-block bg-amber-700 text-white font-bold py-3 px-6 rounded-lg hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition-transform transform hover:scale-105 mr-4">
            Upload Dataset Anda
        </a>
        <a href="<?= site_url('analisis') ?>" class="inline-block bg-amber-700 text-white font-bold py-3 px-6 rounded-lg hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition-transform transform hover:scale-105 mr-4">
            Mulai Analisis
        </a>
    </div>
</div>

<?= $this->endSection() ?>