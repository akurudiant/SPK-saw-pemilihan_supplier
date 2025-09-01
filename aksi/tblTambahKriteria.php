<?php
include '../koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode    = trim($_POST['kode']);
    $nama    = trim($_POST['nama']);
    $bobot   = floatval($_POST['bobot']);
    $atribut = trim($_POST['atribut']);

    // Cek field kosong
    if (empty($kode) || empty($nama) || empty($bobot) || empty($atribut)) {
        $_SESSION['error'] = 'Semua field harus diisi!';
        header('Location: ../index.php?m=kriteria_tambah');
        exit;
    }

    // Cek bobot harus <= 1
    if ($bobot <= 0 || $bobot > 1) {
        $_SESSION['error'] = 'Bobot harus di antara 0 dan 1!';
        header('Location: ../index.php?m=kriteria_tambah');
        exit;
    }

    // Cek apakah kode sudah ada
    $cek = $conn->prepare("SELECT COUNT(*) FROM tb_kriteria WHERE kode = ?");
    $cek->bind_param("s", $kode);
    $cek->execute();
    $cek->bind_result($jumlah);
    $cek->fetch();
    $cek->close();

    if ($jumlah > 0) {
        $_SESSION['error'] = 'Kode kriteria sudah ada!';
        header('Location: ../index.php?m=kriteria_tambah');
        exit;
    }

    // Insert
    $stmt = $conn->prepare("INSERT INTO tb_kriteria (kode, nama_kriteria, nilai_bobot, atribut) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $kode, $nama, $bobot, $atribut);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Kriteria berhasil ditambahkan!';
    } else {
        $_SESSION['error'] = 'Gagal menambahkan kriteria!';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../index.php?m=kriteria');
    exit;
}
?>
