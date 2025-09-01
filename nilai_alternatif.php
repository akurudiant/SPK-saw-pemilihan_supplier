<?php 
include 'koneksi.php';

// Ambil daftar alternatif dengan pencarian (jika ada)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $alternatif_query = "SELECT * FROM tb_alternatif WHERE 
        kode_alternatif LIKE '%$q%' 
        OR nama_alternatif LIKE '%$q%' 
        ORDER BY kode_alternatif";
} else {
    $alternatif_query = "SELECT * FROM tb_alternatif ORDER BY kode_alternatif";
}
$alternatif_result = $conn->query($alternatif_query);

// Simpan alternatif dalam array
$ALTERNATIF = [];
while ($row = $alternatif_result->fetch_assoc()) {
    $ALTERNATIF[$row['kode_alternatif']] = $row['nama_alternatif'];
}

// Ambil kriteria
$kriteria_result = $conn->query("SELECT * FROM tb_kriteria ORDER BY kode");
$KRITERIA = [];
while ($row = $kriteria_result->fetch_assoc()) {
    $KRITERIA[$row['kode']] = $row['nama_kriteria'];
}

// Ambil sub-kriteria
$sub_result = $conn->query("SELECT * FROM tb_sub ORDER BY id");
$SUB = [];
while ($row = $sub_result->fetch_assoc()) {
    $SUB[$row['id']] = ['nama' => $row['nama_sub'], 'kode_kriteria' => $row['kode_kriteria']];
}

// Ambil nilai alternatif
$nilai_result = $conn->query("SELECT * FROM tb_nilai_alternatif");
$NILAI = [];
while ($row = $nilai_result->fetch_assoc()) {
    $NILAI[$row['kode_alternatif']][$row['kode_kriteria']] = $row['id_sub'];
}
?>

<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="page-header">
    <h1>Nilai Bobot Alternatif</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" method="get">
            <input type="hidden" name="m" value="nilai_alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Kode/Nama Alternatif..." />
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Cari</button>
            </div>
            <div class="form-group">
                <a class="btn btn-warning" href="?m=nilai_alternatif"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $kode => $nama): ?>
                        <th><?= htmlspecialchars($nama) ?></th>
                    <?php endforeach; ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ALTERNATIF as $kode_alt => $nama_alt): ?>
                    <tr>
                        <td><?= htmlspecialchars($kode_alt) ?></td>
                        <td><?= htmlspecialchars($nama_alt) ?></td>
                        <?php foreach ($KRITERIA as $kode_kriteria => $nama_kriteria): ?>
                            <?php 
                                $id_sub = $NILAI[$kode_alt][$kode_kriteria] ?? null;
                                $nama_sub = $id_sub && isset($SUB[$id_sub]) ? $SUB[$id_sub]['nama'] : '-';
                            ?>
                            <td><?= htmlspecialchars($nama_sub) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a class="btn btn-xs btn-success" href="?m=nilai_alternatif_ubah&ID=<?= urlencode($kode_alt) ?>">
                                <span class="glyphicon glyphicon-edit"></span> Nilai
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
