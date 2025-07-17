<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-center text-2xl font-bold mb-4"><?= $title ?></h1>

<!-- Tombol Simpan Hasil Prediksi -->
<?php if (isset($is_simulation) && $is_simulation && !empty($data_tabel) && isset($data_tabel[0]['angka_acak'])) : ?>
    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Hasil Simulasi:</strong> Data prediksi telah dihitung namun belum tersimpan. Klik tombol di samping untuk menyimpan hasil.
                    </p>
                </div>
            </div>
            <div class="ml-4">
                <form action="<?= site_url('prediksi/simpan') ?>" method="post" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="data_prediksi" value="<?= htmlspecialchars(json_encode($data_tabel)) ?>">
                    <input type="hidden" name="total_prediksi" value="<?= $total_prediksi ?>">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                        Simpan Hasil Prediksi
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>



<form action="<?= site_url('prediksi') ?>" method="post" class="bg-white p-6 rounded-lg shadow-md mb-6">
    <?= csrf_field() ?>

    <h2 class="text-xl font-semibold mb-4">Input Parameter Angka Acak</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="a" class="block text-sm font-medium text-gray-700">Nilai a</label>
            <input type="number" name="a" id="a" value="<?= old('a', 19) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>
        <div>
            <label for="c" class="block text-sm font-medium text-gray-700">Nilai c</label>
            <input type="number" name="c" id="c" value="<?= old('c', 237) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>
        <div>
            <label for="m" class="block text-sm font-medium text-gray-700">Nilai m</label>
            <input type="number" name="m" id="m" value="<?= old('m', 128) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>
        <div>
            <label for="x0" class="block text-sm font-medium text-gray-700">Nilai Awal (Z₀)</label>
            <input type="number" name="x0" id="x0" value="<?= old('x0', 12357) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>
    </div>

    <!-- Perbaikan struktur HTML dan layout -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="tahun" class="block text-sm font-medium text-gray-700">Filter Tahun</label>
            <select name="tahun" id="tahun" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">Semua Tahun</option>
                <?php if (!empty($available_years)) : ?>
                    <?php foreach ($available_years as $year) : ?>
                        <option value="<?= $year ?>" <?= (isset($selected_year) && $selected_year == $year) ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <!-- Placeholder label to make columns equal height -->
            <label class="block text-sm font-medium text-transparent select-none">&nbsp;</label>
            <button type="submit" class="w-full mt-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                Jalankan Simulasi Prediksi
            </button>
        </div>
    </div>
</form>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3">Nomor</th>
                <th class="px-6 py-3">Tahun</th>
                <th class="px-6 py-3">Kecamatan</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">Probabilitas</th>
                <th class="px-6 py-3">CDF</th>
                <th class="px-6 py-3">Batas</th>
                <th class="px-6 py-3 bg-blue-100">Angka Acak</th>
                <th class="px-6 py-3 bg-green-100">Hasil Prediksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_tabel)) : ?>
                <?php $nomor = 1; ?>
                <?php foreach ($data_tabel as $row) : ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><?= $nomor++ ?></td>
                        <td class="px-6 py-4"><?= $row['tahun'] ?></td>
                        <td class="px-6 py-4"><?= $row['kecamatan'] ?></td>
                        <td class="px-6 py-4"><?= $row['jumlah'] ?></td>
                        <td class="px-6 py-4"><?= number_format($row['probabilitas'], 3) ?></td>
                        <td class="px-6 py-4"><?= number_format($row['cdf'], 3) ?></td>
                        <td class="px-6 py-4"><?= $row['batas'] ?></td>
                        <td class="px-6 py-4 bg-blue-50 font-semibold">
                            <?php if (isset($row['angka_acak'])) : ?>
                                <?= number_format($row['angka_acak'], 3) ?>
                            <?php else : ?>
                                <span class="text-gray-400 text-xs">Menunggu...</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 bg-green-50 font-bold">
                            <?php if (isset($row['hasil_prediksi'])) : ?>
                                <?= $row['hasil_prediksi'] ?>
                            <?php else : ?>
                                <span class="text-gray-400 text-xs">Menunggu...</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="9" class="text-center py-4">
                        Data tidak ditemukan. Silakan pilih tahun yang berbeda atau tambahkan data.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>

        <!-- <<== BAGIAN BARU UNTUK MENAMPILKAN TOTAL ==>> -->
        <?php if (isset($total_prediksi)) : ?>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="8" class="text-left px-6 py-3">Total Nilai Prediksi Pada Tahun Berikutnya</td>
                    <td class="px-6 py-3 bg-green-100"><?= $total_prediksi ?></td>
                </tr>
            </tfoot>
        <?php endif; ?>
        <!-- <<== AKHIR BAGIAN BARU ==>> -->

    </table>
</div>



<!-- Info Status Data Tersimpan -->
<?php if (!empty($data_tabel) && isset($data_tabel[0]['angka_acak']) && (!isset($is_simulation) || !$is_simulation)) : ?>
    <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    <strong>Status:</strong> Data prediksi telah tersimpan dalam database. Anda dapat menjalankan simulasi ulang dengan parameter yang berbeda.
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>