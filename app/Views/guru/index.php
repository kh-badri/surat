<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-4"><?= $title ?></h1>

<div class="mb-4">
    <a href="<?= site_url('guru/create') ?>" class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Tambah
    </a>
</div>

<!-- Tampilkan pesan flashdata -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= session()->getFlashdata('success') ?></p>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Kecamatan</th>
                <th class="px-6 py-3">Tahun</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru)) : ?>
                <?php $nomor = 1; ?>
                <?php foreach ($guru as $row) : ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><?= $nomor++ ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?= $row['kecamatan'] ?></td>
                        <td class="px-6 py-4"><?= $row['tahun'] ?></td>
                        <td class="px-6 py-4"><?= $row['jumlah'] ?></td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="<?= site_url('guru/edit/' . $row['id_guru']) ?>" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semi-bold py-1 px-3 rounded">Edit</a>
                            <a href="<?= site_url('guru/delete/' . $row['id_guru']) ?> " class="bg-red-500 hover:bg-red-600 text-white font-semi-bold py-1 px-3 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada data guru.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <!-- Bagian baru untuk menampilkan total jumlah guru -->
        <?php if (!empty($guru)) : ?>
            <tfoot class="text-xs text-gray-700 uppercase bg-gray-100 font-bold">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right">Total Jumlah Guru </td>
                    <td class="px-6 py-3"><?= esc($total_jumlah_guru); ?></td>
                    <td class="px-6 py-3"></td> <!-- Kosongkan kolom Aksi -->
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</div>

<?= $this->endSection() ?>