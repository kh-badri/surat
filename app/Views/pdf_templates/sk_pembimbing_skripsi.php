<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Usulan SK Dosen Pembimbing Skripsi</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 90px;
            position: absolute;
            left: 50px;
            top: 20px;
        }

        .kop-surat h1,
        .kop-surat h2,
        .kop-surat h3 {
            margin: 0;
            padding: 0;
        }

        .kop-surat h1 {
            font-size: 18pt;
            font-weight: bold;
        }

        .kop-surat h2 {
            font-size: 16pt;
            font-weight: bold;
        }

        .kop-surat h3 {
            font-size: 14pt;
        }

        .kop-surat p {
            font-size: 11pt;
            margin: 5px 0 0 0;
        }

        .content-table {
            width: 100%;
        }

        .content-table td {
            vertical-align: top;
        }

        .lampiran-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .lampiran-table th,
        .lampiran-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 11pt;
        }

        .lampiran-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .tanda-tangan {
            width: 300px;
            margin-top: 50px;
            float: right;
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .footer-text {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat">
            <?php
            $pathToImage = FCPATH . 'public/una.png'; // Menggunakan path ke folder public
            if (file_exists($pathToImage)) {
                $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
                $data = file_get_contents($pathToImage);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $base64 = '';
            }
            ?>
            <img src="<?= $base64; ?>" alt="Logo UNA">

            <h1>UNIVERSITAS ASAHAN</h1>
            <h2>FAKULTAS TEKNIK</h2>
            <h3>PROGRAM STUDI TEKNIK INFORMATIKA</h3>
            <p>Gedung Fak. Teknik, Ruang Program Studi Lantai I, Jl. Jend. Ahmad Yani, Kisaran - 21224</p>
        </div>

        <table class="content-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <table>
                        <tr>
                            <td>Nomor</td>
                            <td>: <?= esc($surat['nomor_surat']); ?></td>
                        </tr>
                        <tr>
                            <td>Lampiran</td>
                            <td>: <?= esc($surat['lampiran'] ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td>Hal</td>
                            <td>: <b><?= esc($surat['perihal']); ?></b></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; vertical-align: top; text-align: left;">
                    Kisaran, <?= date('d F Y', strtotime($surat['tanggal_surat'])); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 15px;">
                    Kepada Yth :<br>
                    Dekan Fakultas Teknik<br>
                    Universitas Asahan<br>
                    di<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
                </td>
            </tr>
        </table>

        <div class="footer-text">
            <p>Dengan hormat,</p>
            <p style="text-align: justify;">1. Sehubungan dengan surat Permohonan Pembimbing Skripsi Mahasiswa yang ditujukan Kepada Ketua Program Studi Teknik Informatika.</p>
            <p style="text-align: justify;">2. Setelah dievaluasi, telah memenuhi persyaratan yang telah ditetapkan oleh Program Studi Teknik Informatika untuk dapat diusulkan Dosen Pembimbing Skripsi Mahasiswa.</p>
            <p style="text-align: justify;">3. Berkenaan dengan hal tersebut diatas, diusulkan kepada Bapak/Ibu Dosen Pembimbing Skripsi untuk ditetapkan dalam Surat Keputusan Dekan. (Terlampir).</p>
            <p style="text-align: justify;">4. Demikian disampaikan, atas perhatian dan persetujuan Bapak diucapkan terima kasih.</p>
        </div>

        <div class="tanda-tangan">
            Hormat Kami,<br>
            Ka.Prodi Teknik Informatika
            <br><br><br><br><br>
            <b><u>Harmayani, ST, M.Kom</u></b><br>
            NIDN. 0130107502
        </div>
        <div class="clear"></div>

        <div style="page-break-before: always;"></div>

        <p>
            <b>Lampiran</b> : Surat Prodi Teknik Informatika tentang Usulan SK Dosen Pembimbing Skripsi<br>
            <b>Nomor</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= esc($surat['nomor_surat']); ?>
        </p>

        <h4 style="text-align: center; text-transform: uppercase; margin-top: 30px;">Daftar Nama Mahasiswa dan Dosen Pembimbing Skripsi</h4>

        <table class="lampiran-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Judul Skripsi</th>
                    <th>Dosen Pembimbing</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // === PERBAIKAN DI SINI ===
                // Menggunakan 'detail_mahasiswa' sesuai dengan nama kolom di database
                $details = json_decode($surat['detail_mahasiswa'] ?? '[]', true);
                $no = 1;
                if (is_array($details) && !empty($details)) :
                    foreach ($details as $detail): ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++; ?></td>
                            <td><?= esc($detail['npm'] ?? ''); ?></td>
                            <td><?= esc($detail['nama'] ?? ''); ?></td>
                            <td><?= esc($detail['judul'] ?? ''); ?></td>
                            <td><?= esc($detail['dosen_pembimbing'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data detail mahasiswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="tanda-tangan" style="margin-top: 30px;">
            Ketua Program Studi<br>
            Teknik Informatika
            <br><br><br><br><br>
            <b><u>Harmayani, ST, M.Kom</u></b><br>
            NIDN. 0130107502
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>