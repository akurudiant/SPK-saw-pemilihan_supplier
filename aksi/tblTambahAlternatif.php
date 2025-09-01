<?php
include '../koneksi.php'; 
session_start(); // WAJIB ADA untuk bisa menyimpan pesan session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_alternatif = trim($_POST['kode_alternatif']);
    $nama_alternatif = trim($_POST['nama_alternatif']);

    // Validasi agar tidak ada field kosong
    if (empty($kode_alternatif) || empty($nama_alternatif)) {
        $_SESSION['error'] = 'Semua field harus diisi!';
        header('Location: ../index.php?m=alternatif_tambah');
        exit;
    }

    // Cek apakah kode_alternatif sudah ada
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tb_alternatif WHERE kode_alternatif = ?");
    $stmt->bind_param("s", $kode_alternatif);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $_SESSION['error'] = 'Kode alternatif sudah ada!';
        header('Location: ../index.php?m=alternatif_tambah');
        exit;
    }

    // Tambahkan data
    $stmt = $conn->prepare("INSERT INTO tb_alternatif (kode_alternatif, nama_alternatif) VALUES (?, ?)");
    $stmt->bind_param("ss", $kode_alternatif, $nama_alternatif);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Alternatif berhasil ditambahkan!';
        header('Location: ../index.php?m=alternatif');
    } else {
        $_SESSION['error'] = 'Gagal menambahkan alternatif!';
        header('Location: ../index.php?m=alternatif_tambah');
    }

    $stmt->close();
    $conn->close();
}
?>
