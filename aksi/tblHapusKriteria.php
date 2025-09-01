<?php
include '../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Query untuk menghapus data dari tabel tb_alternatif (bukan tb_kriteria)
    $query = "DELETE FROM tb_kriteria WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Kriteria berhasil dihapus!';
    } else {
        $_SESSION['error'] = 'Gagal menghapus Kriteria ';
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'ID  tidak ditemukan!';
}

$conn->close();

// Redirect ke halaman utama kriteria
header('Location: ../index.php?m=kriteria');
exit;
?>
