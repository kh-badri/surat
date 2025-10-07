<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Kerja Praktek</title>
    <style>
        /* Mengatur halaman dasar dan font utama */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            /* Margin halaman untuk meniru dokumen Word */
            margin: 0.7in 0.8in;
        }

        /* --- STYLING KOP SURAT --- */

        .kop-surat-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-surat-table .logo-cell {
            width: 15%;
            padding-right: 20px;
        }

        .kop-surat-table .logo {
            width: 95px;
            /* Sedikit disesuaikan ukurannya */
        }

        .kop-surat-table .text-cell {
            width: 85%;
            text-align: center;
            vertical-align: top;
        }

        /* Styling untuk setiap baris teks di kop surat agar sesuai gambar */
        .univ-title {
            font-family: 'Garamond', 'Times New Roman', serif;
            /* Font serif yang lebih elegan */
            font-size: 28pt;
            font-style: italic;
            font-weight: bold;
            color: #222;
            margin: 0;
        }

        .faculty-title {
            font-family: Arial, Helvetica, sans-serif;
            /* Font sans-serif yang tegas */
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0 0 0;
        }

        .prodi-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 3px 0 0 0;
        }

        .address {
            font-family: 'Courier New', Courier, monospace;
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            /* Memberi spasi antar huruf */
            margin-top: 5px;
        }

        /* Tiga garis pemisah (tipis, tebal, tipis) */
        .hr-wrapper {
            margin-top: 5px;
        }

        .hr-line-thin {
            border-top: 0.5px solid black;
        }

        .hr-line-thick {
            border-top: 2px solid black;
            margin: 1px 0;
        }

        /* --- STYLING METADATA & TUJUAN SURAT --- */

        .meta-table {
            width: 100%;
            margin-top: 15px;
        }

        .meta-table td {
            font-size: 12pt;
            vertical-align: top;
        }

        .info-table td {
            padding-bottom: 3px;
        }

        .info-table .label {
            width: 85px;
        }

        .info-table .separator {
            width: 15px;
            text-align: center;
        }

        .kepada-yth {
            margin-top: 20px;
            line-height: 1.5;
        }

        /* --- STYLING ISI SURAT, TANDA TANGAN & LAMPIRAN --- */

        .body-content {
            margin-top: 20px;
        }

        .body-table {
            width: 100%;
        }

        .body-table td {
            padding: 2px 0;
            vertical-align: top;
            text-align: justify;
            line-height: 1.5;
        }

        .body-table .number-col {
            width: 25px;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
        }

        .signature-table .signature-col {
            width: 45%;
        }

        .lampiran-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 20px 0;
        }

        .lampiran-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .lampiran-table th,
        .lampiran-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .lampiran-table th {
            text-align: center;
        }
    </style>
</head>

<body>

    <table class="kop-surat-table">
        <tr>
            <td class="logo-cell">
                <?php
                // Kode ini mengubah gambar menjadi base64 agar pasti ter-render di PDF
                $pathToImage = FCPATH . 'public/una.png';
                $base64 = '';
                if (is_file($pathToImage)) {
                    $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
                    $data = file_get_contents($pathToImage);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
                ?>
                <img src="<?= $base64; ?>" alt="Logo UNA" class="logo">
            </td>
            <td class="text-cell">
                <div class="univ-title">Universitas Asahan</div>
                <div class="faculty-title">FAKULTAS TEKNIK</div>
                <div class="prodi-title">PROGRAM STUDI TEKNIK INFORMATIKA</div>
                <div class="address">Gedung Fak. Teknik, Ruang Program Studi Lantai I, Jl. Jend. Ahmad Yani, Kisaran - 21224</div>
            </td>
        </tr>
    </table>

    <div class="hr-wrapper">
        <div class="hr-line-thin"></div>
        <div class="hr-line-thick"></div>
        <div class="hr-line-thin"></div>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 65%;">
                <table class="info-table">
                    <tr>
                        <td class="label">Nomor</td>
                        <td class="separator">:</td>
                        <td><?= esc($surat['nomor_surat'] ?? '002.1/108/PTI/FT-UNA/2025'); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Lampiran</td>
                        <td class="separator">:</td>
                        <td><?= esc($surat['lampiran'] ?? '1 (satu) berkas'); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Hal</td>
                        <td class="separator">:</td>
                        <td><b><u><?= esc($surat['perihal'] ?? 'Permohonan Surat Pengantar Kerja Praktek'); ?></u></b></td>
                    </tr>
                </table>
            </td>
            <td style="width: 35%;">
                Kisaran, <?= !empty($surat['tanggal_surat']) ? date('d F Y', strtotime($surat['tanggal_surat'])) : '23 Agustus 2025'; ?>
            </td>
        </tr>
    </table>

    <div class="kepada-yth">
        Kepada Yth :<br>
        <b>Dekan Fakultas Teknik</b><br>
        <b>Universitas Asahan</b><br>
        di
        <div style="padding-left: 20px;">Tempat</div>
    </div>

    <div class="body-content">
        <p style="text-indent: 40px;">Dengan hormat,</p>
        <table class="body-table">
            <tr>
                <td class="number-col">1.</td>
                <td>Sehubungan dengan surat Permohonan Kerja Praktek Mahasiswa yang ditujukan Kepada Ketua Program Studi Teknik Informatika.</td>
            </tr>
            <tr>
                <td class="number-col">2.</td>
                <td>Setelah dievaluasi, telah memenuhi persyaratan yang telah ditetapkan oleh Program Studi Teknik Informatika untuk dapat diusulkan Surat Pengantar Kerja Praktek Mahasiswa ke Perusahaan yang dituju.</td>
            </tr>
        </table>
    </div>

    <table class="signature-table">
        <tr>
            <td style="width: 55%;"></td>
            <td class="signature-col">
                Hormat Kami,
                <br>
                Ka.Prodi Teknik Informatika
                <br><br><br><br><br>
                <b style="text-decoration: underline;">Harmavani, ST, M.Kom</b>
                <br>
                NUPTK.6362753654230093
            </td>
        </tr>
    </table>

    <div style="page-break-before: always;"></div>

    <p>
        <b>Lampiran</b> : Surat Prodi Teknik Informatika tentang Permohonan Surat Pengantar Kerja Praktek
        <br>
        <b>Nomor</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= esc($surat['nomor_surat'] ?? '002.1/108/PTI/FT-UNA/2025'); ?>
    </p>

    <div class="lampiran-title">DAFTAR NAMA MAHASISWA DAN TEMPAT KERJA PRAKTEK</div>

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
            <?php if (!empty($mahasiswa)): ?>
                <?php $no = 1;
                foreach ($mahasiswa as $mhs): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><?= esc($mhs['npm']); ?></td>
                        <td><?= esc($mhs['nama_mahasiswa']); ?></td>
                        <td><?= esc($mhs['perusahaan']); ?></td>
                        <td><?= esc($mhs['alamat_perusahaan']); ?></td>
                        <td><?= esc($mhs['waktu_pelaksanaan']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>22012067</td>
                    <td>Nasir Fadillah Marpaung</td>
                    <td>MIS Islamiyah Sigodong-godong</td>
                    <td>Dusun III Desa Gonting Malaha Kec. Bandar Pulau Kab. Asahan</td>
                    <td>25 Agustus s/d 08 Oktober 2025</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td style="width: 55%;"></td>
            <td class="signature-col">
                Ketua Program Studi
                <br>
                Teknik Informatika
                <br><br><br><br><br>
                <b style="text-decoration: underline;">Harmavani, ST, M.Kom</b>
                <br>
                NUPTK.6362753654230093
            </td>
        </tr>
    </table>

</body>

</html>