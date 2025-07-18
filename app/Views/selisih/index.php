<?= $this->extend('layout/layout'); ?>
<?= $this->section('content') ?>

<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Kebutuhan</h1>
        <a href="<?= site_url('selisih/new') ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            Tambah Data Kebutuhan
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden ">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        NO
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Tahun
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Kecamatan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Hasil Prediksi
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Jumlah Guru
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Kebutuhan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Nilai kebutuhan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Keterangan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($selisih as $s) : ?>
                    <tr>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?= $i++; ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?= $s['tahun']; ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?php
                            // Untuk menampilkan nama kecamatan, Anda perlu melakukan query JOIN atau ambil data kecamatan di controller
                            // Untuk sementara, kita tampilkan ID-nya dulu.
                            // Idealnya: $prediksiModel->find($s['kecamatan_id'])['kecamatan'];
                            echo $s['kecamatan'];
                            ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?= $s['hasil_prediksi_id']; ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?= $s['jumlah_guru_id']; ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?= number_format($s['kebutuhan']); ?>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <?php
                            // Check if 'nilai_selisih' key exists and is not null
                            if (isset($s['nilai_selisih']) && is_numeric($s['nilai_selisih'])) {
                                echo number_format($s['nilai_selisih'], 2);
                            } else {
                                echo 'N/A'; // Or any placeholder you prefer
                            }
                            ?>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-sm
                                <?php
                                $keteranganBgClass = '';
                                if ($s['keterangan'] === 'kekurangan') {
                                    $keteranganBgClass = 'bg-red-100';
                                } elseif ($s['keterangan'] === 'kelebihan') {
                                    $keteranganBgClass = 'bg-green-100';
                                }
                                echo $keteranganBgClass;
                                ?>
                                ">
                            <?php
                            $keteranganTextColorClass = '';
                            if ($s['keterangan'] === 'kekurangan') {
                                $keteranganTextColorClass = 'text-red-800 font-semibold';
                            } elseif ($s['keterangan'] === 'kelebihan') {
                                $keteranganTextColorClass = 'text-green-800 font-semibold';
                            }
                            ?>
                            <span class="<?= $keteranganTextColorClass; ?>">
                                <?= $s['keterangan']; ?>
                            </span>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <a href="<?= site_url('selisih/edit/' . $s['id_selisih']); ?>" class="bg-yellow-400 text-black py-1 px-3 rounded-md hover:bg-yellow-500 text-sm">Edit</a>
                            <form action=" <?= site_url('selisih/' . $s['id_selisih']); ?>" method="post" class="inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 text-sm" onclick=" return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">
                        Total Kekurangan:
                    </td>
                    <td colspan="3" class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-sm font-bold text-red-800 tracking-wider">
                        <?= $countKekurangan; ?> </td>
                </tr>
                <tr>
                    <td colspan="6" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">
                        Total Kelebihan:
                    </td>
                    <td colspan="3" class="px-5 py-3 border-b-2 border-gray-200 bg-green-100 text-left text-sm font-bold text-green-800 tracking-wider">
                        <?= $countKelebihan; ?> </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>