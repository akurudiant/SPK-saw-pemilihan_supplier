<?php
// Pastikan koneksi database sudah ada
$jumlah_kriteria = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_kriteria"));
$jumlah_subkriteria = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_sub"));
$jumlah_alternatif = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_alternatif"));
?>

<!-- Dashboard Ringkasan -->
<div class="page-header">
    <h1>Dashboard</h1>
</div>
<div class="row text-center">
    <!-- Kriteria -->
    <div class="col-md-4">
        <a href="index.php?m=kriteria" class="text-decoration-none">
            <div class="panel" style="background-color:rgba(28, 173, 62, 0.94); border-radius: 10px; padding: 15px; color: white;">
                <div class="panel-body">
                    <i class="glyphicon glyphicon-list-alt" style="font-size: 30px; margin-bottom: 5px;"></i>
                    <h5 style="font-size: 16px; margin: 5px 0;">Jumlah Kriteria</h5>
                    <h3 style="font-weight: bold; margin: 0;"><?= $jumlah_kriteria ?></h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Subkriteria -->
    <div class="col-md-4">
        <a href="index.php?m=sub" class="text-decoration-none">
            <div class="panel" style="background-color: #007bff; border-radius: 10px; padding: 15px; color: white;">
                <div class="panel-body">
                    <i class="glyphicon glyphicon-th-list" style="font-size: 30px; margin-bottom: 5px;"></i>
                    <h5 style="font-size: 16px; margin: 5px 0;">Jumlah Subkriteria</h5>
                    <h3 style="font-weight: bold; margin: 0;"><?= $jumlah_subkriteria ?></h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Alternatif -->
    <div class="col-md-4">
        <a href="index.php?m=alternatif" class="text-decoration-none">
            <div class="panel" style="background-color: #FE9900; border-radius: 10px; padding: 15px; color: white;">
                <div class="panel-body">
                    <i class="glyphicon glyphicon-user" style="font-size: 30px; margin-bottom: 5px;"></i>
                    <h5 style="font-size: 16px; margin: 5px 0;">Jumlah Alternatif</h5>
                    <h3 style="font-weight: bold; margin: 0;"><?= $jumlah_alternatif ?></h3>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Panduan -->
<div class="page-header text-center">
    <h2 style="font-weight: bold; color: #34495e;">Panduan Penggunaan</h2>
    <p style="font-size: 16px; color: #7f8c8d;">
        Sistem ini membantu Anda memilih supplier terbaik menggunakan metode <b>Simple Additive Weighting (SAW)</b>.
    </p>
</div>

<div class="well" style="background-color: #f8f9fa; border-left: 5px solid #007bff; border-radius: 10px; padding: 20px;">
    <h4 style="font-weight: bold; color: #34495e;">Langkah-langkah yang perlu dilakukan:</h4>
    <ol style="font-size: 15px; color: #2c3e50; margin-left: 20px;">
        <li>Masukkan <b>Kriteria</b> yang dibutuhkan untuk memilih supplier.</li>
        <li>Tambahkan <b>Subkriteria</b> untuk memperjelas indikator penilaian.</li>
        <li>Masukkan daftar <b>Alternatif</b> (supplier) yang akan dibandingkan.</li>
        <li>Berikan <b>Nilai</b> terhadap setiap alternatif berdasarkan subkriteria.</li>
        <li>Lihat hasil perhitungan sistem SAW untuk menentukan <b>ranking</b> supplier terbaik.</li>
        <li>Analisis hasil perhitungan dalam bentuk grafik untuk mempermudah pengambilan keputusan.</li>
    </ol>
    <p style="font-size: 14px; color: #7f8c8d; margin-top: 15px;">
        <b>Catatan:</b> Anda dapat mengubah <b>password</b> akun Anda di menu <b>Admin Toko &gt; Ubah Password</b>.
    </p>
</div>