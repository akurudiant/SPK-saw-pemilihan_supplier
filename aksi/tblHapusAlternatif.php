<?php
include '../koneksi.php';
session_start();

// Ambil kode alternatif dari parameter GET
$kode_alternatif = isset($_GET['ID']) ? $_GET['ID'] : '';

if (!empty($kode_alternatif)) {
    // Siapkan statement untuk menghapus
    $query = "DELETE FROM tb_alternatif WHERE kode_alternatif = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_alternatif);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Alternatif berhasil dihapus!';
    } else {
        $_SESSION['error'] = 'Gagal menghapus alternatif!';
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'ID alternatif tidak ditemukan!';
}

$conn->close();

// Redirect ke halaman utama alternatif
header('Location: ../index.php?m=alternatif');
exit;
?>
