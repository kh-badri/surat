<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pengantar KP</title>
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
            padding: 20px 0;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
            min-height: 100px;
        }

        .kop-surat img {
            width: 90px;
            height: auto;
            position: absolute;
            left: 40px;
            top: 10px;
        }

        .kop-surat h1,
        .kop-surat h2,
        .kop-surat h3 {
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        .kop-surat h1 {
            font-size: 24pt;
            font-weight: normal;
            font-style: italic;
            margin-bottom: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .kop-surat h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0 3px 0;
            letter-spacing: 1px;
        }

        .kop-surat h3 {
            font-size: 13pt;
            font-weight: bold;
            margin: 3px 0 8px 0;
            letter-spacing: 0.5px;
        }

        .kop-surat p {
            font-size: 10pt;
            margin: 0;
            padding: 0;
            font-style: italic;
        }

        .header-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-left {
            float: left;
            width: 50%;
        }

        .header-right {
            float: right;
            width: 45%;
            text-align: left;
            padding-left: 20px;
        }

        .header-left table {
            border-collapse: collapse;
        }

        .header-left table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .header-left table td:first-child {
            width: 80px;
        }

        .header-left table td:nth-child(2) {
            width: 10px;
        }

        .clear {
            clear: both;
        }

        .content-text {
            margin-top: 20px;
            text-align: justify;
        }

        .content-text p {
            margin: 10px 0;
            text-align: justify;
        }

        .tanda-tangan {
            width: 300px;
            margin-top: 30px;
            float: right;
            text-align: left;
            line-height: 1.5;
        }

        .tanda-tangan-nama {
            margin-top: 60px;
        }

        .cc-file {
            margin-top: 100px;
            clear: both;
        }

        /* Halaman 2 - Lampiran */
        .page-break {
            page-break-before: always;
        }

        .lampiran-header {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .lampiran-title {
            text-align: center;
            text-transform: uppercase;
            margin: 30px 0 20px 0;
            font-weight: bold;
            font-size: 12pt;
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
            font-size: 11pt;
        }

        .lampiran-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .lampiran-table td {
            vertical-align: top;
        }

        .lampiran-table td:first-child {
            text-align: center;
            width: 40px;
        }

        .lampiran-table td:nth-child(2) {
            width: 90px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Halaman 1 -->
        <div class="kop-surat">
            <?php
            $pathToImage = FCPATH . 'public/una.png';
            if (is_file($pathToImage)) {
                $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
                $data = file_get_contents($pathToImage);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $base64 = '';
            }
            ?>
            <img src="<?= $base64; ?>" alt="Logo UNA">

            <h1>Universitas Asahan</h1>
            <h2>FAKULTAS TEKNIK</h2>
            <h3>PROGRAM STUDI TEKNIK INFORMATIKA</h3>
            <p>Gedung Fak. Teknik, Ruang Program Studi Lantai I, Jl. Jend. Ahmad Yani, Kisaran - 21224</p>
        </div>

        <div class="header-section">
            <div class="header-right" style="float: right; margin-bottom: 20px;">
                Kisaran, <?= date('d F Y', strtotime($surat['tanggal_surat'])); ?>
            </div>
        </div>
        <div class="clear"></div>

        <div class="header-section">
            <div class="header-left">
                <table>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td><?= esc($surat['nomor_surat']); ?></td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td><?= esc($surat['lampiran']); ?></td>
                    </tr>
                    <tr>
                        <td>Hal</td>
                        <td>:</td>
                        <td><b><?= esc($surat['perihal']); ?></b></td>
                    </tr>
                </table>
            </div>

            <div class="header-right">
                Kepada Yth :<br>
                Dekan Fakultas Teknik<br>
                Universitas Asahan<br>
                di<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
            </div>
        </div>
        <div class="clear"></div>

        <div class="content-text">
            <p>Dengan hormat,</p>
            <p>1. Sehubungan dengan surat Permohonan Kerja Praktek Mahasiswa yang ditujukan Kepada Ketua Program Studi Teknik Informatika.</p>
            <p>2. Setelah dievaluasi, telah memenuhi persyaratan yang telah ditetapkan oleh Program Studi Teknik Informatika untuk dapat diusulkan Surat Pengantar Kerja Praktek Mahasiswa ke Perusahaan yang dituju.</p>

            <?php if (!empty($mahasiswa) && isset($mahasiswa[0]['waktu_pelaksanaan'])): ?>
                <p>3. Waktu Pelaksanaa Kerja Praktek : <?= esc($mahasiswa[0]['waktu_pelaksanaan']); ?></p>
            <?php endif; ?>

            <p>4. Berkenaan dengan hal tersebut diatas, diusulkan kepada Bapak Dekan Nama Mahasiswa serta tempat Kerja Praktek.</p>
            <p>5. Demikian disampaikan, atas perhatian dan persetujuan Bapak diucapkan terima kasih.</p>
        </div>

        <div class="tanda-tangan">
            Hormat Kami,<br>
            Ka.Prodi Teknik Informatika
            <div class="tanda-tangan-nama">
                <b><u>Harmayani, ST, M.Kom</u></b><br>
                NUPTK.6362753654230093
            </div>
        </div>

        <div class="cc-file">
            Cc. File
        </div>

        <!-- Halaman 2 - Lampiran -->
        <div class="page-break"></div>

        <div class="lampiran-header">
            <b>Lampiran</b> : Surat Prodi Teknik Informatika tentang Permohonan Surat Pengantar Kerja Praktek<br>
            <b>Nomor</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= esc($surat['nomor_surat']); ?>
        </div>

        <h4 class="lampiran-title">Daftar Nama Mahasiswa dan Tempat Kerja Praktek</h4>

        <table class="lampiran-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nama Perusahaan</th>
                    <th>Alamat Perusahaan</th>
                    <th>Waktu Pelaksanaan KP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($mahasiswa as $mhs): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($mhs['npm']); ?></td>
                        <td><?= esc($mhs['nama_mahasiswa']); ?></td>
                        <td><?= esc($mhs['perusahaan']); ?></td>
                        <td><?= esc($mhs['alamat_perusahaan']); ?></td>
                        <td><?= esc($mhs['waktu_pelaksanaan']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="tanda-tangan">
            Ketua Program Studi<br>
            Teknik Informatika
            <div class="tanda-tangan-nama">
                <b><u>Harmayani, ST, M.Kom</u></b><br>
                NUPTK.6362753654230093
            </div>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>