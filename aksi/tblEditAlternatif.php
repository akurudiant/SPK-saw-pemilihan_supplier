<?php
include '../koneksi.php';
session_start();

// Ambil data dari form
$kode_alternatif = $_POST['kode_alternatif'];
$nama_alternatif = $_POST['nama_alternatif'];

// Validasi agar tidak ada field kosong
if (empty($kode_alternatif) || empty($nama_alternatif)) {
    $_SESSION['error'] = 'Semua field harus diisi!';
    header('Location: ../index.php?m=alternatif_edit&ID=' . urlencode($kode_alternatif));
    exit;
}

// Update data ke database
$query = "UPDATE tb_alternatif SET nama_alternatif = ? WHERE kode_alternatif = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $nama_alternatif, $kode_alternatif);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Alternatif berhasil diubah!';
} else {
    $_SESSION['error'] = 'Gagal mengubah data alternatif!';
}

$stmt->close();
$conn->close();

// Redirect ke halaman utama alternatif
header("Location: ../index.php?m=alternatif");
exit;
?>
