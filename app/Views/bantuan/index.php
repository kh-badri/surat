<?= $this->extend('layout/layout'); ?> <?= $this->section('content') ?> <div class="container mx-auto p-4 font-['Helvetica_Neue',_Helvetica,_Arial,_sans-serif']">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="flex items-center text-gray-800 text-3xl font-bold mb-6 border-b-2 border-blue-200 pb-3"> <i class="fas fa-question-circle mr-3 text-blue-600"></i> Bantuan
        </h1>

        <div class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-blue-100 text-blue-800 font-semibold px-6 py-3 border-b border-blue-200">
                    <h2 class="flex items-center text-lg"><i class="fas fa-list-ol mr-2"></i>Panduan Penggunaan Aplikasi</h2>
                </div>
                <table class="w-full">
                    <tbody>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Administrator login terlebih dahulu.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Pilih menu <strong>Jenis Data</strong> untuk memasukkan data yang tersedia.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Kemudian pilih menu <strong>Data Tenaga Pendidik</strong> untuk menginput jumlah tenaga pendidik per kecamatan dengan memilih tahun dan jenis data, lalu klik <strong>hitung</strong> untuk menampilkan tabel perhitungan hasil distribusi.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Setelah muncul tabel, klik <strong>simpan</strong> untuk menyimpan data persediaan tenaga pendidik. Setelah tersimpan, akan muncul tabel kebutuhan tenaga pendidik.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Pilih menu <strong>Bilangan Acak</strong> untuk menghasilkan nilai random yang digunakan dalam prediksi, lalu klik <strong>simpan</strong>. Proses ini hanya dilakukan satu kali.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Pilih menu <strong>Hasil Prediksi</strong> untuk melihat hasil akhir estimasi kebutuhan tenaga pendidik. Pilih jenis data yang tersedia, maka hasilnya akan muncul di tabel. Klik <strong>"print"</strong> untuk mencetak laporan atau <strong>"simpan"</strong> untuk menyimpan hasilnya.</td>
                        </tr>
                        <tr class="border-b border-blue-100 last:border-b-0">
                            <td class="p-4 text-blue-600 w-12 text-center align-top"><i class='fa fa-check-circle text-xl'></i></td>
                            <td class="p-4 text-sm text-gray-700">Langkah terakhir adalah pilih menu <strong>Grafik</strong> untuk menampilkan grafik dari hasil prediksi yang telah tersimpan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 text-sm rounded-lg shadow-sm">
                <h3 class="flex items-center text-blue-700 text-xl font-semibold mb-3">
                    <i class="fas fa-random mr-3 text-blue-600"></i> Sekilas Tentang Metode Monte Carlo
                </h3>
                <p class="mb-3 text-gray-700"><strong>Monte Carlo</strong> adalah metode komputasi berbasis simulasi acak yang digunakan untuk memprediksi hasil dalam kondisi ketidakpastian. Metode ini menggunakan sejumlah besar angka acak untuk mensimulasikan berbagai kemungkinan hasil dalam sistem atau proses yang kompleks.</p>
                <p class="mb-3 text-gray-700">Dalam konteks aplikasi prediksi kebutuhan tenaga pendidik, metode Monte Carlo digunakan untuk:</p>
                <ul class="list-disc pl-8 mb-3 text-gray-700">
                    <li>Menghasilkan angka acak yang mewakili kemungkinan permintaan tenaga pendidik di masa depan.</li>
                    <li>Melakukan prediksi berdasarkan distribusi probabilitas dari data historis yang telah diolah sebelumnya.</li>
                    <li>Menangani ketidakpastian data dan memberikan estimasi yang lebih realistis.</li>
                </ul>
                <p class="text-gray-700">Karena sifatnya yang fleksibel dan tidak bergantung pada model matematis kompleks, metode ini sangat efektif dalam pengambilan keputusan berbasis simulasi, terutama dalam perencanaan dan prediksi jangka pendek hingga menengah.</p>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>