<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>



<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500 text-sm">Total Produk</p>
        <h2 class="text-2xl font-bold text-blue-600">123</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500 text-sm">Pengguna Aktif</p>
        <h2 class="text-2xl font-bold text-green-600">1</h2>
    </div>
</div>


<?= $this->endSection() ?>