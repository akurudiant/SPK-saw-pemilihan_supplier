<?php
include 'koneksi.php';

// Ambil kode alternatif dari parameter GET
$kode_alternatif = isset($_GET['ID']) ? $_GET['ID'] : '';

// Ambil data alternatif berdasarkan kode
$query = "SELECT * FROM tb_alternatif WHERE kode_alternatif = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $kode_alternatif);
$stmt->execute();
$result = $stmt->get_result();
$alternatif = $result->fetch_assoc();

if (!$alternatif) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='?m=alternatif';</script>";
    exit;
}
?>

<div class="page-header">
    <h1>Edit Alternatif</h1>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="aksi/tblEditAlternatif.php">
            <input type="hidden" name="kode_alternatif" value="<?= $alternatif['kode_alternatif'] ?>">
            
            <div class="form-group">
                <label>Kode Alternatif</label>
                <input type="text" class="form-control" value="<?= $alternatif['kode_alternatif'] ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Nama Alternatif</label>
                <input type="text" class="form-control" name="nama_alternatif" required value="<?= htmlspecialchars($alternatif['nama_alternatif']) ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-save"></span> Simpan Perubahan
            </button>
            <a href="?m=alternatif" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Kembali
            </a>
        </form>
    </div>
</div>
