<?php
session_start();
include '../koneksi.php';

if ($_GET['act'] == 'rel_alternatif_ubah' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_alternatif = $_POST['kode_alternatif'];

    // Update nilai yang sudah ada
    if (!empty($_POST['nilai'])) {
        foreach ($_POST['nilai'] as $id_nilai => $id_sub) {
            $id_nilai = intval($id_nilai);
            $id_sub = intval($id_sub);

            $stmt = $conn->prepare("UPDATE tb_nilai_alternatif SET id_sub = ? WHERE id = ?");
            $stmt->bind_param("ii", $id_sub, $id_nilai);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Insert nilai baru jika ada kriteria baru yang belum pernah diisi
    if (!empty($_POST['nilai_baru'])) {
        foreach ($_POST['nilai_baru'] as $kode_kriteria => $id_sub) {
            $kode_kriteria = trim($kode_kriteria);
            $id_sub = intval($id_sub);

            $stmt = $conn->prepare("INSERT INTO tb_nilai_alternatif (kode_alternatif, kode_kriteria, id_sub) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $kode_alternatif, $kode_kriteria, $id_sub);
            $stmt->execute();
            $stmt->close();
        }
    }

    $_SESSION['success'] = "Nilai berhasil disimpan!";
    header("Location: ../index.php?m=nilai_alternatif");
    exit;
}
?>
