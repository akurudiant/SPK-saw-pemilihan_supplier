<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Pastikan ID ada dan valid
    if (empty($id)) {
        $_SESSION['error'] = 'ID Sub Kriteria tidak ditemukan!';
        header('Location: ../index.php?m=sub');
        exit;
    }

    // Hapus data
    $query = "DELETE FROM tb_sub WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Sub Kriteria berhasil dihapus!';
    } else {
        $_SESSION['error'] = 'Gagal menghapus Sub Kriteria!';
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'ID Sub Kriteria tidak ditemukan!';
}

$conn->close();

// Redirect ke halaman Sub Kriteria
header('Location: ../index.php?m=sub');
exit;
?>
