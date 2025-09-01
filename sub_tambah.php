<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

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
<!-- END ALERT -->
<div class="page-header">
    <h1>Tambah Sub</h1>
</div><div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="aksi/tblTambahSubKriteria.php">
            <div class="form-group">
                <label>Kode Kriteria</label>
                <select class="form-control" name="kode_kriteria" id="kode_kriteria" required>
                    <option value="">-- Pilih Kode Kriteria --</option>
                    <?php
                    include 'koneksi.php';
                    $query_kriteria = "SELECT kode, nama_kriteria FROM tb_kriteria ORDER BY kode";
                    $result_kriteria = $conn->query($query_kriteria);
                    $kriteria_data = [];
                    while ($row = $result_kriteria->fetch_assoc()) :
                        $kriteria_data[$row['kode']] = $row['nama_kriteria'];
                    ?>
                        <option value="<?= $row['kode'] ?>"><?= $row['kode'] ?> - <?= $row['nama_kriteria'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Kriteria</label>
                <input type="text" class="form-control" id="nama_kriteria" readonly>
            </div>
            <div class="form-group">
                <label>Nama Sub Kriteria</label>
                <input type="text" class="form-control" name="nama_sub" required>
            </div>
            <div class="form-group">
                <label>Nilai Bobot</label>
                <input type="number" step="0.01" class="form-control" name="nilai_bobot" required>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a href="?m=sub" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Kembali
            </a>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var kriteriaData = <?= json_encode($kriteria_data) ?>;
        $('#kode_kriteria').change(function() {
            var kode = $(this).val();
            $('#nama_kriteria').val(kriteriaData[kode] || '');
        });
    });
</script>
