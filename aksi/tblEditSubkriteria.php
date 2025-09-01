<?php
include '../koneksi.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_sub = trim($_POST['nama_sub']);
    $nilai_bobot = trim($_POST['nilai_bobot']);

    // Validasi agar tidak ada field kosong
    if (empty($kode_kriteria) || empty($nama_sub) || empty($nilai_bobot)) {
        $_SESSION['error'] = 'Semua field harus diisi!';
        header('Location: ../index.php?m=EditSubKriteria&id=' . $id);
        exit;
    }

    // Update data sub kriteria
    $stmt = $conn->prepare("UPDATE tb_sub SET kode_kriteria = ?, nama_sub = ?, nilai_bobot = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $kode_kriteria, $nama_sub, $nilai_bobot, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Sub Kriteria berhasil diperbarui!';
        header('Location: ../index.php?m=sub');
        exit;  // Penting untuk menghentikan eksekusi setelah redirect
    } else {
        $_SESSION['error'] = 'Gagal memperbarui Sub Kriteria!';
        header('Location: ../index.php?m=EditSubKriteria&id=' . $id);
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>