<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Surat Usulan SK Dosen Pembimbing KP</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
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
            position: relative;
        }

        .kop-surat img {
            width: 115px;
            position: absolute;
            left: 0;
            top: -20px;
            /* geser 10px ke atas */
        }


        .kop-surat h1,
        .kop-surat h2 {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .kop-surat h1 {
            font-size: 16pt;
            margin-left: 10px;
        }

        .kop-surat h2 {
            font-size: 18pt;
            margin-left: 35px;
        }

        .kop-surat p {
            font-size: 11pt;
            margin: 0 20px 0 0;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-table td {
            vertical-align: top;
            padding: 2px;
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
        }

        .lampiran-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .tanda-tangan {
            width: 300px;
            margin-top: 30px;
            float: right;
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .footer-text {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat">
            <?php
            // Pastikan file 'una.png' ada di dalam folder public Anda
            $pathToImage = FCPATH . '/public/una.png';
            if (is_file($pathToImage)) {
                $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
                $data = file_get_contents($pathToImage);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $base64 = '';
            }
            ?>
            <img src="<?= $base64; ?>" alt="Logo UNA">

            <h1>FAKULTAS TEKNIK</h1>
            <h2>PROGRAM STUDI TEKNIK INFORMATIKA</h2>
            <p>Gedung Fak. Teknik, Ruang Program Studi Lantai I, Jl. Jend. Ahmad Yani, Kisaran - 21224</p>
        </div>

        <table class="content-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 20%;">Nomor</td>
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
            <p style="text-align: justify;">Sehubungan dengan surat Permohonan Pembimbing Kerja Praktek Mahasiswa yang ditujukan Kepada Ketua Program Studi Teknik Informatika.</p>
            <p style="text-align: justify;">Setelah dievaluasi, telah memenuhi persyaratan yang telah ditetapkan oleh Program Studi Teknik Informatika untuk dapat diusulkan Dosen Pembimbing Kerja Praktek Mahasiswa.</p>
            <p style="text-align: justify;">Berkenaan dengan hal tersebut diatas, diusulkan kepada Bapak/Ibu Dosen Pembimbing Kerja Praktek untuk ditetapkan dalam Surat Keputusan Dekan. (Terlampir).</p>
            <p style="text-align: justify;">Demikian disampaikan, atas perhatian dan persetujuan Bapak diucapkan terima kasih.</p>
        </div>

        <div class="tanda-tangan">
            Hormat Kami,<br>
            Ka.Prodi Teknik Informatika
            <br><br><br><br><br>
            <b><u>Harmayani, ST, M.Kom</u></b><br>
            NIDN. 0130107502
        </div>
        <div class="clear"></div>
        <p>Cc. File</p>

        <div style="page-break-before: always;"></div>

        <p>
            <b>Lampiran</b> : Surat Prodi Teknik Informatika tentang Usulan SK Dosen Pembimbing Kerja Praktek<br>
            <b>Nomor</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= esc($surat['nomor_surat']); ?>
        </p>

        <h4 style="text-align: center; text-transform: uppercase; margin-top: 30px;">Daftar Nama Mahasiswa dan Dosen Pembimbing Kerja Praktek</h4>

        <table class="lampiran-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nama Perusahaan</th>
                    <th>Judul Laporan Kerja Praktek</th>
                    <th>Dosen Pembimbing</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($mahasiswa as $mhs) : ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><?= esc($mhs['npm']); ?></td>
                        <td><?= esc($mhs['nama_mahasiswa']); ?></td>
                        <td><?= esc($mhs['perusahaan']); ?></td>
                        <td><?= esc($mhs['judul']); ?></td>
                        <td><?= esc($mhs['dosen_pembimbing']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="tanda-tangan">
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