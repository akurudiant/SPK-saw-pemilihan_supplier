<?php
session_start();
include '../koneksi.php';

$id            = $_POST['id'];
$nama_kriteria = $_POST['nama_kriteria'];
$nilai_bobot   = floatval($_POST['nilai_bobot']);
$atribut       = $_POST['atribut'];

// Cek bobot harus <= 1
if ($nilai_bobot <= 0 || $nilai_bobot > 1) {
    $_SESSION['error'] = 'Bobot harus di antara 0 dan 1!';
    header('Location: ../index.php?m=EditKriteria&id=' . $id);
    exit;
}

// Update data
$sql = "UPDATE tb_kriteria 
        SET nama_kriteria=?, nilai_bobot=?, atribut=? 
        WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsi", $nama_kriteria, $nilai_bobot, $atribut, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Data kriteria berhasil diperbarui.";
} else {
    $_SESSION['error'] = "Tidak ada perubahan data atau gagal update.";
}

header("Location: ../index.php?m=kriteria");
exit;
?>
