<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('') ?>" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Produk</h1>

        <a href="/produk/create" class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Produk
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama Produk</th>
                        <th class="px-4 py-2 border-b">Harga</th>
                        <th class="px-4 py-2 border-b">Stok</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produk)): ?>
                        <?php $no = 1;
                        foreach ($produk as $p): ?>
                            <tr class="text-gray-800 hover:bg-gray-50">
                                <td class="px-4 py-2 border-b"><?= $no++ ?></td>
                                <td class="px-4 py-2 border-b"><?= esc($p['nama_produk']) ?></td>
                                <td class="px-4 py-2 border-b">Rp <?= number_format($p['harga']) ?></td>
                                <td class="px-4 py-2 border-b"><?= $p['stok'] ?></td>
                                <td class="px-4 py-2 border-b space-x-2">
                                    <a href="/produk/edit/<?= $p['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="/produk/delete/<?= $p['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center px-4 py-4 text-gray-500">Tidak ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>