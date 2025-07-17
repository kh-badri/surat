<?= $this->extend('layout/layout'); // Sesuaikan dengan layout utama Anda 
?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-bold mb-4"><?= esc($title); ?></h2>
        </div>
        <div class="my-4 flex justify-between items-center">

            <a href="<?= site_url('siswa/new') ?>" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 shadow-sm inline-block text-center font-semibold">
                + Tambah
            </a>
            <form action="<?= site_url('siswa') ?>" method="get" class="flex items-center space-x-2">
                <label for="tahun" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter Tahun:</label>
                <select name="tahun" id="tahun" class="block w-full sm:w-48 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" onchange="this.form.submit()">
                    <option value="">-- Tampilkan Semua --</option>
                    <?php if (!empty($tahun_list)) : ?>
                        <?php foreach ($tahun_list as $t) : ?>
                            <option value="<?= $t ?>" <?= ($selected_tahun == $t) ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700  bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">NO.</th>
                        <th scope="col" class="px-6 py-3">TAHUN</th>
                        <th scope="col" class="px-6 py-3">NAMA KECEMATAN </th>
                        <th scope="col" class="px-6 py-3">JUMLAH</th>
                        <th scope="col" class="px-6 py-3">PROBABILITAS</th>
                        <th scope="col" class="px-6 py-3">CDF</th>
                        <th scope="col" class="px-6 py-3">BATAS Ri</th>
                        <th scope="col" class="px-6 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswa_list)) : ?>
                        <tr class="bg-white border-b">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa_list as $s) : ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $i++; ?>
                                </th>
                                <td class="px-6 py-4"><?= esc($s['tahun']); ?></td>
                                <td class="px-6 py-4"><?= esc($s['kecamatan']); ?></td>
                                <td class="px-6 py-4"><?= esc($s['jumlah']); ?></td>
                                <td class="px-6 py-4"><?= esc(number_format($s['probabilitas'], 4)); ?></td>
                                <td class="px-6 py-4"><?= esc(number_format($s['cdf'], 4)); ?></td>
                                <td class="px-6 py-4"><?= esc($s['batas']); ?></td>
                                <td class="px-6 py-4">
                                    <a href="<?= base_url('siswa/' . $s['id_siswa']) . '/edit' ?>" class="bg-yellow-400 text-black py-1 px-3 rounded-md hover:bg-yellow-500 text-sm">Edit</a>
                                    <form action="<?= base_url('siswa/' . $s['id_siswa']) ?>" method="post" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 text-sm" onclick=" return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($siswa_list)) : ?>
                    <tfoot class="text-xs text-gray-700 bg-gray-100 font-bold">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right uppercase">Total Jumlah Siswa </td>
                            <td class="px-6 py-3"><?= esc($total_jumlah); ?></td>
                            <td colspan="4" class="px-6 py-3"></td> <!-- Kosongkan sisa kolom -->
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>