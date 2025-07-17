<?= $this->extend('layout/layout') // Sesuaikan dengan file layout utama Anda 
?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-4"><?= esc($title) ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md">

    <a href="<?= site_url('wilayah/new') ?>" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 mb-4 inline-block shadow-sm">
        + Tambah
    </a>

    <div class="relative overflow-x-auto border rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Nama Kecamatan</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($wilayah as $w) : ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <?= $i++ ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= esc($w['kecamatan']) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?= site_url('wilayah/' . $w['id'] . '/edit') ?>" class="bg-yellow-400 text-black py-1 px-3 rounded-md hover:bg-yellow-500 text-sm">Edit</a>

                            <form action="<?= site_url('wilayah/' . $w['id']) ?>" method="post" class="inline ml-1">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>