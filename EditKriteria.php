<?php
include 'koneksi.php';

// Ambil ID dari GET atau POST
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

// Cek ID valid
if ($id <= 0) {
    echo "Data tidak ditemukan!";
    exit;
}

// Query data kriteria
$query = "SELECT * FROM tb_kriteria WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Cek data ada atau tidak
if (!$row) {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!-- ALERT JIKA ADA -->
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<!-- END ALERT -->

<div class="page-header">
    <h1>Edit Kriteria</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <form method="post" action="aksi/tblEditKriteria.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
            
            <div class="form-group">
                <label>Kode</label>
                <input class="form-control" type="text" name="kode" value="<?= htmlspecialchars($row['kode']) ?>" readonly />
            </div>
            
            <div class="form-group">
                <label>Nama Kriteria</label>
                <input class="form-control" type="text" name="nama_kriteria" value="<?= htmlspecialchars($row['nama_kriteria']) ?>" required />
            </div>
            
            <div class="form-group">
                <label>Nilai Bobot</label>
                <input class="form-control" type="number" step="0.01" name="nilai_bobot" value="<?= htmlspecialchars($row['nilai_bobot']) ?>" required />
            </div>
            
            <div class="form-group">
                <label>Atribut</label>
                <select class="form-control" name="atribut">
                    <option value="benefit" <?= $row['atribut'] === 'benefit' ? 'selected' : '' ?>>Benefit</option>
                    <option value="cost" <?= $row['atribut'] === 'cost' ? 'selected' : '' ?>>Cost</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-save"></span> Simpan
                </button>
                <a class="btn btn-danger" href="index.php?m=kriteria">
                    <span class="glyphicon glyphicon-arrow-left"></span> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
