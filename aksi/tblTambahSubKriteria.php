<?php
include '../koneksi.php'; 

// Memulai session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_sub = $_POST['nama_sub'];
    $nilai_bobot = $_POST['nilai_bobot'];

    // Validasi agar tidak ada field yang kosong
    if (empty($kode_kriteria) || empty($nama_sub) || empty($nilai_bobot)) {
        $_SESSION['error'] = 'Semua field harus diisi!';
        echo "<script>window.location='../index.php?m=sub_tambah';</script>";
        exit;
    }

    // Menambahkan data ke tabel tb_sub
    $stmt = $conn->prepare("INSERT INTO tb_sub (kode_kriteria, nama_sub, nilai_bobot) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kode_kriteria, $nama_sub, $nilai_bobot);

    // Menyimpan data dan memberikan pesan sukses atau error
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Sub Kriteria berhasil ditambahkan!';
        header('Location: ../index.php?m=sub');
    } else {
        $_SESSION['error'] = 'Gagal menambahkan Sub Kriteria!';
        header('Location: ../index.php?m=sub_tambah');
    }

    $stmt->close();
    $conn->close();
}
?>
