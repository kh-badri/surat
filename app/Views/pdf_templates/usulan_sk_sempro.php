<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Surat Usulan SK Seminar Proposal</title>
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
            position: relative;
        }

        .kop-surat img {
            width: 90px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .kop-surat h1,
        .kop-surat h2 {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .kop-surat h1 {
            font-size: 16pt;
        }

        .kop-surat h2 {
            font-size: 18pt;
        }

        .kop-surat p {
            font-size: 11pt;
            margin: 5px 0 0 0;
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
            vertical-align: top;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat">
            <?php
            $pathToImage = FCPATH . 'una.png';
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
                            <td>: <?= esc($surat['lampiran'] ?? '1 (satu) berkas'); ?></td>
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
                    Bapak Dekan Fakultas Teknik<br>
                    Universitas Asahan<br>
                    di<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
                </td>
            </tr>
        </table>

        <div class="footer-text" style="margin-top: 30px;">
            <p>Dengan hormat,</p>
            <p style="text-align: justify;">Sehubungan dengan Permohonan Seminar Proposal Mahasiswa yang ditujukan Kepada Ketua Program Studi Teknik Informatika.</p>
            <p style="text-align: justify;">Setelah dievaluasi, telah memenuhi persyaratan yang telah ditetapkan oleh Program Studi Teknik Informatika untuk dapat diusulkan Dosen Pembanding Seminar Proposal.</p>
            <p style="text-align: justify;">Berkenaan dengan hal tersebut diatas, diusulkan kepada Bapak/Ibu Dosen Pembanding untuk ditetapkan dalam Surat Keputusan (Terlampir).</p>
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
            <b>Lampiran</b> : Surat Prodi Teknik Informatika tentang <?= esc($surat['perihal']); ?><br>
            <b>Nomor</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= esc($surat['nomor_surat']); ?>
        </p>

        <h4 style="text-align: center; text-transform: uppercase; margin-top: 30px;">Daftar Nama Mahasiswa dan Dosen Pembanding Seminar Proposal</h4>

        <table class="lampiran-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 12%;">NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th style="width: 25%;">Judul Skripsi</th>
                    <th style="width: 18%;">Dosen Pembimbing</th>
                    <th style="width: 18%;">Dosen Pembanding I/II</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php if (!empty($mahasiswa) && is_array($mahasiswa)) : ?>
                    <?php foreach ($mahasiswa as $mhs) : ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++; ?></td>
                            <td><?= esc($mhs['npm']); ?></td>
                            <td><?= esc($mhs['nama_mahasiswa']); ?></td>
                            <td><?= esc($mhs['judul']); ?></td>
                            <td><?= esc($mhs['dosen_pembimbing']); ?></td>
                            <td><?= nl2br(esc($mhs['dosen_pembanding'] ?? '')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data mahasiswa.</td>
                    </tr>
                <?php endif; ?>
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