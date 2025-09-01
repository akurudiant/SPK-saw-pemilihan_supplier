
<?php
include 'koneksi.php';

// Ambil ID sub kriteria yang akan diedit
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Ambil data sub kriteria berdasarkan ID
$query = "SELECT s.*, k.nama_kriteria FROM tb_sub s 
          JOIN tb_kriteria k ON s.kode_kriteria = k.kode 
          WHERE s.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$sub_kriteria = $result->fetch_assoc();

if (!$sub_kriteria) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='?m=sub';</script>";
    exit;
}
?>

<div class="page-header">
    <h1>Edit Sub Kriteria</h1>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="aksi/tblEditSubKriteria.php">
            <input type="hidden" name="id" value="<?= $sub_kriteria['id'] ?>">
            
            <div class="form-group">
                <label>Kode Kriteria</label>
                <input type="text" class="form-control" name="kode_kriteria" value="<?= $sub_kriteria['kode_kriteria'] ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Nama Kriteria</label>
                <input type="text" class="form-control" value="<?= $sub_kriteria['nama_kriteria'] ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Nama Sub Kriteria</label>
                <input type="text" class="form-control" name="nama_sub" required value="<?= htmlspecialchars($sub_kriteria['nama_sub']) ?>">
            </div>
            
            <div class="form-group">
                <label>Nilai Bobot</label>
                <input type="number" step="0.01" class="form-control" name="nilai_bobot" required value="<?= htmlspecialchars($sub_kriteria['nilai_bobot']) ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-save"></span> Simpan Perubahan
            </button>
            <a href="?m=sub" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Kembali
            </a>
        </form>
    </div>
</div>
