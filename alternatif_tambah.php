<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- ALERT JIKA ADA -->

<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="page-header">
    <h1>Tambah Alternatif</h1>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="aksi/tblTambahAlternatif.php">
            <div class="form-group">
                <label>Kode Alternatif</label>
                <input type="text" class="form-control" name="kode_alternatif" required>
            </div>
            <div class="form-group">
                <label>Nama Alternatif</label>
                <input type="text" class="form-control" name="nama_alternatif" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-save"></span> Simpan
            </button>
            <a href="?m=alternatif" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Kembali
            </a>
        </form>
    </div>
</div>
